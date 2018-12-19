<?php
require("vendor/autoload.php");
$main = dirname(__DIR__, 3) . "Users\\Bernard-ng\\pictures\\NGPICTURES";
$server = new \Ng\Photoserver\Server($main);
$server->render(2, 4);