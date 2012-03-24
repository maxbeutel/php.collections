<?php

namespace Collection;

interface BasicCollectionInterface
{
	public function count();

	public function add($item);

	public function remove($item);

	public function contains($item);

	public function toArray();
}