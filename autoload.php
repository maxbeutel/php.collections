<?php

require_once __DIR__ . '/vendor/symfony/class-loader/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->register();

$loader->registerNamespace('Collection', __DIR__ . '/src');
$loader->registerNamespace('Symfony\\Component\\Console', __DIR__ . '/vendor/symfony/console');