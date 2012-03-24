<?php

namespace Collection;

use Iterator;
use Countable;
use Collection\Assert as Assert;
use Collection\HashSet\HashCode;
use Collection\Shared\InitializeCollectionTrait;
use Collection\Shared\BasicCollectionTrait;

class HashSet implements Iterator, Countable, BasicCollectionInterface
{
	use InitializeCollectionTrait;
	use BasicCollectionTrait;

	protected $position = 0;
	protected $count = 0;
	protected $internalCollection = [];

	public function __construct($collection = null)
	{
		Assert\ArgumentType::isTraversableOrNull($collection, 1, __METHOD__);

		$this->initialize($collection);
	}

	public function rewind() 
	{
		$this->position = 0;
		return reset($this->internalCollection);
	}

	public function current() 
	{
		return current($this->internalCollection);
	}

	public function key() 
	{
		return null;
	}

	public function next() 
	{
		$this->position++;
		return next($this->internalCollection);
	}

	public function valid() 
	{
		return $this->position < $this->count;
	}

	protected function doCount()
	{
		return $this->count;
	}

	protected function doAdd($item)
	{
		$hashCode = (string) new HashCode($item);

		$this->internalCollection[$hashCode] = $item;

		$this->count++;

		return $this;
	}

	protected function doRemove($item)
	{
		$hashCode = (string) new HashCode($item);

		if (isset($this->internalCollection[$hashCode])) {
			unset($this->internalCollection[$hashCode]);

			$this->count--;
		}

		return $this;
	}

	protected function doContains($item)
	{
		$hashCode = (string) new HashCode($item);

		return isset($this->internalCollection[$hashCode]);
	}

	public function toArray()
	{
		return array_values($this->internalCollection);
	}
}