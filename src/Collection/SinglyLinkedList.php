<?php

namespace Collection;

use Iterator;
use Countable;
use ArrayAccess;
use InvalidArgumentException;
use Collection\Assert as Assert;
use Collection\Shared\InitializeCollectionTrait;
use Collection\Shared\BasicCollectionTrait;
use Collection\SinglyLinkedList\Node;

class SinglyLinkedList implements Iterator, Countable, ArrayAccess, BasicCollectionInterface
{
	use InitializeCollectionTrait;
	use BasicCollectionTrait;

	protected $internalCollection = array();
	protected $count = 0;

	protected $first;
	protected $last;

	protected $current;

	public function __construct($collection)
	{
		Assert\ArgumentType::isTraversableOrNull($collection, 1, __METHOD__);

		$this->initialize($collection);
	}

    public function rewind() 
    {
    	$this->current = $this->first;
    	return true;
    }

    public function current() 
    {
        return $this->current;
    }

    public function key() 
    {
        return null;
    }

    public function next() 
    {
		$this->current = $this->current->next();
		return true;
    }

    public function valid() 
    {
 		return $this->current !== null;
    }

	public function offsetSet($offset, $value) 
	{
    }
    
    public function offsetExists($offset) 
    {
    }
    
    public function offsetUnset($offset) 
    {
    }
    
    public function offsetGet($offset) 
    {
    }

    public function addFirst($item)
    {
    	Assert\ArgumentType::notNull($item, 1, __METHOD__);

    	$previousFirst = $this->first;
    	$node = $item instanceof Node ? $item : new Node($item, $previousFirst);

    	$this->first = $node;

    	$this->count++;

    	return $this;
    }

    public function addAfter(Node $node, $item)
    {
    }

    public function addBefore(Node $node, $item)
    {
    }

	protected function doCount()
	{
		return $this->count;
	}

	protected function doAdd($item)
	{
		$node = new Node($item, null);

		if (!$this->first && !$this->last) {
			$this->first = $this->last = $node;
		}

		if ($this->last) {
			$previousLast = $this->last;
			$previousLast->setNext($node);

			$this->last = $node;
		}

		$this->count++;

		return $this;
	}

	protected function doRemove($item)
	{
		$compareNodes = $item instanceof Node;

		$previousNode = null;

		foreach ($this as $node) {
			if ($compareNodes) {
				if ($node === $item) {
					$previousNode->setNext($node->next());

					$this->count--;					
				}
			} else {
				if ($node->value() === $item) {
					$previousNode->setNext($node->next());

					$this->count--;
				}
			}

			$previousNode = $node;
		}

		return $this;
	}

	protected function doContains($item)
	{
		$compareNodes = $item instanceof Node;

		foreach ($this as $node) {
			if ($compareNodes) {
				if ($node === $item) {
					return true;
				} 
			} else {
				if ($node->value() === $item) {
					return true;
				}
			}
		}

		return false;
	}
}