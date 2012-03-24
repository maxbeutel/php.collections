<?php

spl_autoload_register(function($className) {
	$file = str_replace(array('_', '\\'), DIRECTORY_SEPARATOR, $className) . '.php';
	if (strpos($className, 'Collection') === 0) {
		require_once __DIR__ . '/src/' . $file;
	}
});