<?php
require("vendor/autoload.php");
$main = dirname(__DIR__, 3) . "Users\\Bernard-ng\\pictures\\NGPICTURES";
$current = __DIR__;


/**
 * Check if the size is defined in query params
 * and define the 'height' and the 'width' of the
 * image that will be rendered
 */
if (isset($_GET['size']) && !empty($_GET['size'])) {
    $size = explode('/', strval($_GET['size']));

    $width =  $size[0] ?? null;
    $height = (count($size) === 2)? ($size[1] ?? $width) : $width;

    $size = [
        'width' => (intval($width) === 0) ? 500 : intval($width),
        'height' => (intval($height) === 0)? 500 : intval($height)
    ];
}

$server = new \Ng\Photoserver\Server(compact('main', 'current'), $size ?? []);
$server->render();