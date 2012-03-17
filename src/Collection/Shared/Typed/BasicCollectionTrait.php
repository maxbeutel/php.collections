<?php

namespace Collection\Shared\Typed;

use Collection\Assert as Assert;

trait BasicCollectionTrait
{
	public function count()
	{
		return $this->doCount();
	}

	public function add($item)
	{
		Assert\ArgumentType::isInstanceOf($this->typeName, $item, 1, __METHOD__);

		return $this->doAdd($item);
	}

	public function remove($item)
	{
		Assert\ArgumentType::isInstanceOf($this->typeName, $item, 1, __METHOD__);

		return $this->doRemove($item);
	}

	public function contains($item)
	{
		Assert\ArgumentType::isInstanceOf($this->typeName, $item, 1, __METHOD__);

		return $this->doContains($item);
	}
}