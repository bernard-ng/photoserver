<?php
namespace Ng\Photoserver;
use Intervention\Image\ImageManager;


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
    private $mainDir;

    /**
     * Server constructor.
     * @param string $mainDir
     */
    public function __construct(string $mainDir)
    {
       try {
           $this->mainDir = new \DirectoryIterator($mainDir);
       } catch (\Exception $e) {
           die($e);
       }
    }


    /**
     * Get Subdirectories in the mainDir
     * @return array
     */
    private function getSubDirs(): array
    {
        $subDirs = [];
        foreach ($this->mainDir as $dir) {
            if ($dir->getFilename() != '.' && $dir->getFilename() != '..' && !empty($dir->getFilename())) {
                if (is_dir($dir->getPathname())) {
                    $subDirs[] = $dir->getPathname();
                }
            }
        }

        return $subDirs;
    }


    /**
     * Get a photo in the main directory
     * @param int $fileIndex
     * @return null|string
     */
    private function getInMainDir(int $fileIndex = 0): ?string
    {
        $files = [];
        foreach ($this->mainDir as $dir) {
            if ($dir->getFilename() != '.' && $dir->getFilename() != '..') {
                if (in_array(strtolower($dir->getExtension()), ['jpg', 'png', 'gif', 'jpeg'])) {
                    $files[] = $dir->getPathname();
                }
             }
            if ($dir->getFilename() != '.' && $dir->getFilename() != '..' && !empty($dir->getFilename())) {
                $files[] = $dir->getPathname();
            }
        }

        $file = $files[mt_rand($fileIndex, count($files) - 1)] ?? $files[0] ?? null;
        return (is_file($file)) ? $file : null;
    }


    /**
     * Get a photos in a subdirectory
     * @param int $index
     * @param int $fileIndex
     * @return null|string
     */
    private function getInSubDirs(int $index = 0, int $fileIndex = 0): ?string
    {
        $subDirsLength = count($this->getSubDirs());
        $index = ($index > $subDirsLength) ? $subDirsLength : ($index < 0) ? 0 : $index;
        $currentDir = $this->getSubDirs()[mt_rand(0, count($this->getSubDirs()) - 1)] ?? $this->getSubDirs()[$index];
        $files = [];

        try {
            $currentDir = new \DirectoryIterator($currentDir);
        } catch (\Exception $e) {
            die($e);
        }

        foreach ($currentDir as $file) {
            if ($file->getFilename() != '.' && $file->getFilename() != '..') {
               if (in_array(strtolower($file->getExtension()), ['jpg', 'png', 'gif', 'jpeg'])) {
                   $files[] = $file->getPathname();
               }
            }
        }

        $file = $files[mt_rand($fileIndex, count($files) - 1)] ?? $files[0] ?? null;
        return (is_file($file)) ? $file : null;
    }


    /**
     * Render the photo in the web browser
     * @param int $dirIndex
     * @param int $fileIndex
     */
    public function render(int $dirIndex = 0, int $fileIndex = 0) {
        try {
            $image = new ImageManager();
            $image = $image->make($this->getInSubDirs($dirIndex, $fileIndex));
            echo $image->response('jpeg');
        } catch (\Exception $e) {
            die($e);
        }
    }
} 