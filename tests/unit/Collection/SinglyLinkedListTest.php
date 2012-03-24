<?php

namespace Collection;

use PHPUnit_Framework_TestCase;
use Collection\SinglyLinkedList\Node;

class SinglyLinkedListTest extends PHPUnit_Framework_TestCase
{
	public function testInitialCollectionArgumentMustBeTraversable()
	{
		$list = new SinglyLinkedList();
		$list = new SinglyLinkedList(null);

		$this->setExpectedException('InvalidArgumentException', 'Argument 1 to Collection\SinglyLinkedList::__construct must be array or instance of Traversable');

		$list = new SinglyLinkedList('invalid value');
	}

	public function testCount()
	{
		$list = new SinglyLinkedList();
		$this->assertCount(0, $list);

		$items = range(0, 10);

		$list = new SinglyLinkedList($items);
		$this->assertCount(count($items), $list);
	}

	public function testListStoresDuplicates()
	{
		$list = new SinglyLinkedList([7, 7]);

		$this->assertSame([7, 7], $list->toArray());		
	}

	public function testAddToEmptyList()
	{
		$list = new SinglyLinkedList();
		$list->add(19);
		$list->add(2);
		$list->add(3);

		$this->assertCount(3, $list);
		$this->assertSame([19, 2, 3], $list->toArray());
	}

	public function testAddPreinitializedList()
	{
		$list = new SinglyLinkedList([5, 75, -1]);
		$list->add(19);
		$list->add(2);
		$list->add(3);

		$this->assertCount(6, $list);
		$this->assertSame([5, 75, -1, 19, 2, 3], $list->toArray());
	}

	public function testContainsValue()
	{
		$list = new SinglyLinkedList([6]);

		$this->assertFalse($list->contains(1));
		$this->assertTrue($list->contains(6));
	}

	public function testContainsNode()
	{
		$list = new SinglyLinkedList([6]);

		$theNode = null;

		foreach ($list as $node) {
			$theNode = $node;
		}

		$this->assertTrue($list->contains($theNode));		
	}

	public function testAddFirstToEmptyList()
	{
		$list = new SinglyLinkedList();
		
		$this->assertNull($list->first());
		$this->assertNull($list->last());

		$list->addFirst(7);

		$this->assertSame(7, $list->first());
		$this->assertSame(7, $list->last());
	}

	public function testAddFirstToListContainingOneItem()
	{
		$list = new SinglyLinkedList([8]);
		
		$this->assertSame(8, $list->first());
		$this->assertSame(8, $list->last());
		$this->assertCount(1, $list);

		$list->addFirst(-1);

		$this->assertSame(-1, $list->first());
		$this->assertSame(8, $list->last());

		$this->assertCount(2, $list);
	}

	public function testAddFirstToNonEmptyList()
	{
		$list = new SinglyLinkedList([1, 2, 3]);

		$this->assertSame(1, $list->first());
		$this->assertSame(3, $list->last());
		$this->assertCount(3, $list);

		$list->addFirst(6);

		$this->assertSame(6, $list->first());
		$this->assertSame(3, $list->last());
		$this->assertCount(4, $list);

		$this->assertSame([6, 1, 2, 3], $list->toArray());
	}

	public function testRemoveFromEmptyList()
	{
		$list = new SinglyLinkedList();

		$list->remove(9);

		$this->assertCount(0, $list);
	}

	public function testRemoveValueNotFound()
	{
		$list = new SinglyLinkedList([1, 2, 3]);

		$this->assertCount(3, $list);
		
		$list->remove(8);
		
		$this->assertCount(3, $list);
	}

	public function testRemoveNodeNotFound()
	{
		$list = new SinglyLinkedList([1, 2, 3]);

		$this->assertCount(3, $list);
		
		$list->remove(new Node(8));
		$list->remove(new Node(1));
		
		$this->assertCount(3, $list);		
	}

	public function testRemoveInBetweenValue()
	{
		$list = new SinglyLinkedList([1, 2, 3]);

		$this->assertTrue($list->contains(2));
		$this->assertSame(1, $list->first());
		$this->assertSame(3, $list->last());
		
		$list->remove(2);

		$this->assertSame(1, $list->first());
		$this->assertSame(3, $list->last());
		$this->assertFalse($list->contains(2));

		$this->assertSame([1, 3], $list->toArray());
		$this->assertCount(2, $list);
	}

	public function testRemoveLastValue()
	{
		$list = new SinglyLinkedList([1, 2, 3]);

		$this->assertTrue($list->contains(2));
		$this->assertSame(1, $list->first());
		$this->assertSame(3, $list->last());

		$list->remove(3);

		$this->assertFalse($list->contains(3));
		$this->assertSame(1, $list->first());
		$this->assertSame(2, $list->last());

		$this->assertSame([1, 2], $list->toArray());
		$this->assertCount(2, $list);
	}

	public function testRemoveValueFromListContainingOneItem()
	{
		$list = new SinglyLinkedList([3]);

		$this->assertTrue($list->contains(3));
		$this->assertSame(3, $list->first());
		$this->assertSame(3, $list->last());

		$list->remove(3);

		$this->assertNull($list->first());
		$this->assertNull($list->last());

		$this->assertSame([], $list->toArray());
		$this->assertCount(0, $list);
	}
}