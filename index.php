<?php
require("vendor/autoload.php");
$main = dirname(__DIR__, 3) . "Users\\Bernard-ng\\pictures\\NGPICTURES";


/**
 * Check if the size is defined in query params
 * and define the 'height' and the 'width' of the
 * image that will be rendered
 */
if (isset($_GET['size']) && !empty($_GET['size'])) {
    $size = explode('/', strval($_GET['size']));
    $height = $size[0] ?? null;
    $width = (count($size) == 2)? ($size[1] ?? $height) : $height;

    $size = compact('height', 'width');
}

$server = new \Ng\Photoserver\Server($main, $size ?? []);
$server->render();