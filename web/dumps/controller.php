<?php

$dir    = '../upload';
$files = scandir($dir);

header('Content-Type: text/plain');

foreach ($files as $file) {
	if ( $file !== "." && $file !== "..")
		echo $file . "\r\n";
}

?>