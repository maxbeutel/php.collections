<?php

namespace Collection\Shared;

use Collection\Assert as Assert;

trait BasicCollectionTrait
{
	public function count()
	{
		return $this->doCount();
	}

	public function add($item)
	{
		Assert\ArgumentType::notNull($item, 1, __METHOD__);

		return $this->doAdd($item);
	}

	public function remove($item)
	{
		Assert\ArgumentType::notNull($item, 1, __METHOD__);

		return $this->doRemove($item);
	}

	public function contains($item)
	{
		Assert\ArgumentType::notNull($item, 1, __METHOD__);

		return $this->doContains($item);
	}
}