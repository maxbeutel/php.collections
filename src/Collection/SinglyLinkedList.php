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

class SinglyLinkedList implements Iterator, Countable, BasicCollectionInterface
{
	use InitializeCollectionTrait;
	use BasicCollectionTrait;

	protected $count = 0;

	protected $first;
	protected $last;

	protected $current;

	public function __construct($collection = null)
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

	public function addFirst($item)
	{
		Assert\ArgumentType::notNull($item, 1, __METHOD__);

		$node = $item instanceof Node ? $item : new Node($item);
		$node->setNext(null);
		

		if ($this->count === 0) {
			$this->first = $this->last = $node;
		} else {
			$previousFirst = $this->first;
			
			$this->first = $node;
			$this->first->setNext($previousFirst);	
		}

		$this->count++;

		return $this;
	}

	public function first($defaultNodeValue = null)
	{
		return $this->hasFirst() ? $this->first : new Node($defaultNodeValue);
	}

	public function hasFirst()
	{
		return $this->first instanceof Node;
	}

	public function tail()
	{
		if (!$this->first) {
			return new static();
		}

		$list = new static();
		$list->first = $this->first->next();
		$list->last = $this->last === $this->first ? $list->first : $this->last;
		$list->count = $this->count > 0 ? $this->count - 1 : 0;

		return $list;
	}

	public function last($defaultNodeValue = null)
	{
		return $this->hasLast() ? $this->last : new Node($defaultNodeValue);
	}

	public function hasLast()
	{
		return $this->last instanceof Node;
	}

	public function find($value, $defaultNodeValue = null)
	{
		foreach ($this as $node) {
			if ($node->value() === $value) {
				return $node;
			}
		}

		return new Node($defaultNodeValue);
	}

	protected function doCount()
	{
		return $this->count;
	}

	protected function doAdd($item)
	{
		$node = $item instanceof Node ? $item : new Node($item);
		$node->setNext(null);

		if (!$this->first && !$this->last) {
			$this->first = $this->last = $node;
		}

		if ($this->last && $this->last !== $node) {
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
			$comparisionResult = ($compareNodes ? $node : $node->value()) === $item;

			if ($comparisionResult) {
				if ($previousNode) {
					$previousNode->setNext($node->next());

					if (!$node->hasNext()) {
						$this->last = $previousNode;
					}						
				} else {
					$this->first = $node->next();

					if (!$node->hasNext()) {
						$this->last = $this->first;
					}						
				}

				$this->count--;					
			}

			$previousNode = $node;
		}

		return $this;
	}

	protected function doContains($item)
	{
		$compareNodes = $item instanceof Node;

		foreach ($this as $node) {
			$comparisionResult = ($compareNodes ? $node : $node->value()) === $item;

			if ($comparisionResult) {
				return true;
			}
		}

		return false;
	}

	public function toArray()
	{
		$array = [];

		foreach ($this as $node) {
			$array[] = $node->value();
		}

		return $array;
	}
}