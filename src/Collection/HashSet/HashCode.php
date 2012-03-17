<?php

namespace Collection\HashSet;

class HashCode
{
	private $item;

	public function __construct($item)
	{
		$this->item = $item;
	}

	public function __toString()
	{
		if ($this->item instanceof HashableInterface) {
			return (string) $this->item->getHashCode();
		}

		if (is_object($this->item)) {
			return spl_object_hash($this->item);
		}

		return (string) $this->item;
	}
}