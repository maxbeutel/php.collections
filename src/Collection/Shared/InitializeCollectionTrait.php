<?php

namespace Collection\Shared;

use InvalidArgumentException;

trait InitializeCollectionTrait
{
	protected function initialize($collection)
	{
		if ($collection === null) {
			return;
		}

		foreach ($collection as $item) {
			try {
				$this->add($item);
			} catch (InvalidArgumentException $e) {
				throw new InvalidArgumentException('Could not initialize collection', $e->getCode(), $e);                   
			}
		}
	}
}