<?php

require_once __DIR__ . '/../autoload.php';

$hashSet = new Collection\HashSet();
$hashSet->add('1');
$hashSet->add('2');
$hashSet->add('3');
$hashSet->add('4');

foreach ($hashSet as $item) {
	var_dump($item);
}

print_r($hashSet);
print_r($hashSet->toArray());


$typedHashSet = new Collection\Typed\HashSet('integer');
$typedHashSet->add("foo");