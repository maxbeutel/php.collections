<?php

namespace Collection\SinglyLinkedList;

class Node
{
	protected $value; 

	protected $next;

	public function __construct($value, $next = null)
	{
		$this->value = $value;
		$this->next = $next;
	}

	public function value()
	{
		return $this->value;
	}

	public function next()
	{
		return $this->next;
	}

	public function hasNext()
	{
		return $this->next !== null;
	}

	public function hasValue()
	{
		return $this->value != null;
	}

	/** @internal */
	public function setNext($next)
	{
		$this->next = $next;
	}
}