<?php

$mainDir = new DirectoryIterator(dirname(__DIR__, 3) . "Users\Bernard-ng\pictures\NGPICTURES");
$photosDir = [];

foreach ($mainDir as $dir) {
	if ($dir->getFilename() != '.' && $dir->getFilename() != '..' && !empty($dir->getFilename())) {
		$photosDir[] = $dir->getPathname();
	}
}

$sizeLimitDir = count($photosDir) - 1;


function get(int $indexDir, int $indexFile, array $photosDir, int $sizeLimitDir)
{
	global $sizeLimitDir;
	global $photosDir;

	$indexDir = ($indexDir > $sizeLimitDir) ? $sizeLimitDir : ($indexDir < 0) ? 0 : $indexDir;
	$photoDir = $photosDir[$indexDir];
	$files = [];

	foreach (new DirectoryIterator($photoDir) as $photo) {
		if ($photo->getFilename() != '.' && $photo->getFilename() != '..') {
			$files[] = $photo->getPathname();
		}
	}

	$file = $files[$indexFile] ?? $files[0] ?? null;
	$file = require($file);
}


get(7, 0);