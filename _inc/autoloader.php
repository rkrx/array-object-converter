<?php
spl_autoload_register(function ($className) {
	if($className == 'PHPUnit_Extensions_Story_TestCase') {
		return;
	}
	$filename = str_replace('\\', '/', $className);
	/** @noinspection PhpIncludeInspection */
	require_once "{$filename}.php";
});

$string = get_include_path();
$paths = explode(PATH_SEPARATOR, $string);
$paths[] = 'src';
$paths[] = 'tests';
$string = join(PATH_SEPARATOR, $paths);
set_include_path($string);