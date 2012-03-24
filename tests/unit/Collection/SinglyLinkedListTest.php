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

	public function testFirstDefaultValue()
	{
		$list = new SinglyLinkedList();

		$this->assertNull($list->first()->value());
		$this->assertSame('empty', $list->first('empty')->value());
	}

	public function testLastDefaultValue()
	{
		$list = new SinglyLinkedList();

		$this->assertNull($list->last()->value());
		$this->assertSame('empty', $list->last('empty')->value());		
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
		
		$this->assertNull($list->first()->value());
		$this->assertNull($list->last()->value());

		$list->addFirst(7);

		$this->assertSame(7, $list->first()->value());
		$this->assertSame(7, $list->last()->value());
	}

	public function testAddFirstToListContainingOneItem()
	{
		$list = new SinglyLinkedList([8]);
		
		$this->assertSame(8, $list->first()->value());
		$this->assertSame(8, $list->last()->value());
		$this->assertCount(1, $list);

		$list->addFirst(-1);

		$this->assertSame(-1, $list->first()->value());
		$this->assertSame(8, $list->last()->value());

		$this->assertCount(2, $list);
	}

	public function testAddFirstToNonEmptyList()
	{
		$list = new SinglyLinkedList([1, 2, 3]);

		$this->assertSame(1, $list->first()->value());
		$this->assertSame(3, $list->last()->value());
		$this->assertCount(3, $list);

		$list->addFirst(6);

		$this->assertSame(6, $list->first()->value());
		$this->assertSame(3, $list->last()->value());
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
		$this->assertSame(1, $list->first()->value());
		$this->assertSame(3, $list->last()->value());
		
		$list->remove(2);

		$this->assertSame(1, $list->first()->value());
		$this->assertSame(3, $list->last()->value());
		$this->assertFalse($list->contains(2));

		$this->assertSame([1, 3], $list->toArray());
		$this->assertCount(2, $list);
	}

	public function testRemoveInBetweenNode()
	{
		$list = new SinglyLinkedList([1, 2, 3]);
		$node = $list->find(2);

		$this->assertTrue($list->contains($node));
		$this->assertSame(1, $list->first()->value());
		$this->assertSame(3, $list->last()->value());
		
		$list->remove($node);

		$this->assertSame(1, $list->first()->value());
		$this->assertSame(3, $list->last()->value());
		$this->assertFalse($list->contains($node));

		$this->assertSame([1, 3], $list->toArray());
		$this->assertCount(2, $list);		
	}

	public function testRemoveLastValue()
	{
		$list = new SinglyLinkedList([1, 2, 3]);

		$this->assertTrue($list->contains(2));
		$this->assertSame(1, $list->first()->value());
		$this->assertSame(3, $list->last()->value());

		$list->remove(3);

		$this->assertFalse($list->contains(3));
		$this->assertSame(1, $list->first()->value());
		$this->assertSame(2, $list->last()->value());

		$this->assertSame([1, 2], $list->toArray());
		$this->assertCount(2, $list);
	}

	public function testRemoveLastNode()
	{
		$list = new SinglyLinkedList([1, 2, 3]);
		$node = $list->find(3);

		$this->assertTrue($list->contains($node));
		$this->assertSame(1, $list->first()->value());
		$this->assertSame(3, $list->last()->value());

		$list->remove($node);

		$this->assertFalse($list->contains(3));
		$this->assertSame(1, $list->first()->value());
		$this->assertSame(2, $list->last()->value());

		$this->assertSame([1, 2], $list->toArray());
		$this->assertCount(2, $list);
	}

	public function testRemoveValueFromListContainingOneItem()
	{
		$list = new SinglyLinkedList([3]);

		$this->assertTrue($list->contains(3));
		$this->assertSame(3, $list->first()->value());
		$this->assertSame(3, $list->last()->value());

		$list->remove(3);

		$this->assertNull($list->first()->value());
		$this->assertNull($list->last()->value());

		$this->assertSame([], $list->toArray());
		$this->assertCount(0, $list);
	}

	public function testRemoveNodeFromListContainingOneItem()
	{
		$list = new SinglyLinkedList([3]);
		$node = $list->find(3);

		$this->assertTrue($list->contains($node));
		$this->assertSame(3, $list->first()->value());
		$this->assertSame(3, $list->last()->value());

		$list->remove($node);

		$this->assertNull($list->first()->value());
		$this->assertNull($list->last()->value());

		$this->assertSame([], $list->toArray());
		$this->assertCount(0, $list);
	}

	public function testTailFromEmptyList()
	{
		$list = new SinglyLinkedList();
		
		$tail = $list->tail();

		$this->assertFalse($list->hasFirst());
		$this->assertFalse($list->hasLast());
		$this->assertCount(0, $list);
		$this->assertSame([], $list->toArray());
	}

	public function testTail()
	{
		$list = new SinglyLinkedList([1, 2, 3]);
		
		$tail = $list->tail();

		$this->assertSame(2, $tail->first()->value());
		$this->assertSame(3, $tail->last()->value());
		$this->assertCount(2, $tail);
		$this->assertSame([2, 3], $tail->toArray());
	}

	public function testFind()
	{
		$list = new SinglyLinkedList([1, 2, 3]);

		$node = $list->find(3);

		$this->assertSame(3, $node->value());		
	}

	public function testFindDefaultValue()
	{
		$list = new SinglyLinkedList([1, 2, 3]);

		$node = $list->find(6, 'empty');

		$this->assertSame('empty', $node->value());		
	}
}