<?php

require_once __DIR__ . '/../autoload.php';

$list = new Collection\SinglyLinkedList(array('foo', 'bar', 'baz'));

foreach ($list as $node) {
	var_dump($node->value());
	//var_dump($node->tail());
}

var_dump($list->count());

print PHP_EOL;
print PHP_EOL;
print PHP_EOL;

$list->addFirst('new first');

foreach ($list as $node) {
	var_dump($node);
	//var_dump($node->tail());
}

var_dump($list->count());

print PHP_EOL;
print PHP_EOL;
print PHP_EOL;

$list->remove('bar');

foreach ($list as $node) {
	var_dump($node);
	//var_dump($node->tail());
}

var_dump($list->count());