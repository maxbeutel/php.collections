<?php

require_once __DIR__ . '/../autoload.php';

$list = new Collection\SinglyLinkedList(['foo']);

foreach ($list as $l) {
	var_dump($l->value());
}

$list = new Collection\SinglyLinkedList(['foo', 'bar']);

foreach ($list as $l) {
	var_dump($l->value());
}


die();

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


print '##########' . PHP_EOL;
print 'head';
$head = $list->head();
$tail = $list->tail();

var_dump($head);
var_dump($tail->contains('baz'));
