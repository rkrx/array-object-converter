<?php
spl_autoload_register(function ($className) {
	$filename = str_replace('\\', '/', $className);
	require_once "src/{$filename}.php";
});
