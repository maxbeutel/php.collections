<?php

namespace Collection\Typed;

use Collection\HashSet as BaseHashSet;
use Collection\Assert as Assert;
use Collection\Shared\Typed\BasicCollectionTrait;

class HashSet extends BaseHashSet
{
	use BasicCollectionTrait;

	protected $typeName;

	public function __construct($typeName, $collection = null)
	{
		parent::__construct($collection);
		$this->typeName = $typeName;
	}
}