<?php
namespace Ng\Photoserver;
use Intervention\Image\ImageManager;
use Intervention\Image\Exception\InvalidArgumentException;


/**
 * Class Server
 * @package Ng\Photoserver
 */
class Server 
{

    /**
     * The Directory that is containing photos or subdirectories of photos
     * @var string
     */
    private $directories;


    /**
     * The size that the server must render an image
     * @var array
     */
    private $size = [];


    /**
     * Server constructor.
     * @param $directories
     */
    public function __construct(array $directories, array $size)
    {
        $this->directories = $directories;

        if (isset($this->directories['main']) && is_dir($this->directories['main'])) {
            $this->size = $size;
        } else {
            throw new InvalidArgumentException(
                "The photoserver 'main directory' is not set or is not a valid directory"
            );
        }
    }


    /**
     * get a non empty directory in the main directory
     * @return array|null
     */
    private function getDirectory(): ?string
    {
        chdir($this->directories['main']);
        $dirs = glob("*", GLOB_ONLYDIR);
        
        if (!empty($dirs)) {
            $directoryCount = $this->count($dirs);
            $directoryIndex = mt_rand(0, $directoryCount - 1);
            $currentFetchDirectory = $this->directories['main'] . DIRECTORY_SEPARATOR . $dirs[$directoryIndex];
            
            if(is_dir($currentFetchDirectory)) {
                return $currentFetchDirectory;
            }
            return null;
        }
        return null;
    }


    /**
     * get a valid file
     *
     * @param string|null $directory
     * @return string|null
     */
    private function getFile(?string $directory): ?string
    {
        if (!is_null($directory)) {
            chdir($directory);
            $files = glob("*.*", GLOB_ERR);

            if (!empty($files)) {
                $fileCount = $this->count($files);
                $fileIndex = mt_rand(0, $fileCount - 1);
                $currentFile = $directory . DIRECTORY_SEPARATOR . $files[$fileIndex];

                if (is_file($currentFile)) {
                    return $currentFile;
                }
                return null;
            }
            return null;
        }
        return null;
    }


    /**
     * count value in array
     * return 1 if the array is empty
     *
     * @param array $data
     * @return integer
     */
    private function count(array $data): int
    {
        return (count($data) === 0) ? 1 : count($data);
    }


    /**
     * Render the photo in the web browser
     * @param int $dirIndex
     * @param int $fileIndex
     */
    public function render() {
        $file = $this->getFile($this->getDirectory());

        // if a file is not found, we will generate a image with a fancy text
        if (!is_null($file)) {
            try {
                $image = new ImageManager();
                $image = $image->make($file);
               
                if (!empty($this->size)) {
                    $image = $image->fit($this->size['width'], $this->size['height']);
                }
    
                echo $image->response('jpeg');
            } catch (\Exception $e) {
                die($e);
            }
        } else {
            $image = new ImageManager();
            $width = $this->size['width'] ?? 500;
            $height = $this->size['height'] ?? 500;

            // play with the ratio so that we can have a very clean fancy text
            $x = ceil($width - (65 * $width / 100));
            $y = ceil($height / 2);
            $f = ceil($x * $y / 100);

            $fontFile = $this->directories['current'] . DIRECTORY_SEPARATOR . "roboto.ttf";

            echo $image
                ->canvas($width, $height, "#5e5c5c")
                ->text("Photoserver", $x, $y, function ($font) use ($fontFile, $f) {
                    $font->file($fontFile);
                    $font->size($f);
                    $font->color("#fff");
                    $font->align('center');
                    $font->valign('bottom');
                })
                ->response('jpeg', 100);
        }
    }
} 