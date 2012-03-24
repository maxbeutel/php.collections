<?php

namespace Collection;

use PHPUnit_Framework_TestCase;

class HashSetTest extends PHPUnit_Framework_TestCase
{
	public function testHashSetSwallowsDuplicates()
	{
		$set = new HashSet([1, 1, 2]);
		$this->assertSame([1, 2], $set->toArray());

		$set = new HashSet(['1', 1, 2]);
		$this->assertSame([1, 2], $set->toArray());

		$set = new HashSet([1, 2]);
		$set->add(1);
		$this->assertSame([1, 2], $set->toArray());
	}

	public function testAddItemsToPreInitializedSet()
	{
		$set = new HashSet([1, 2, 3]);
		
		$this->assertCount(3, $set);

		$set->add(4);
		$set->add(5);

		$this->assertCount(5, $set);
	}

	public function testAddItemsToEmptySet()
	{
		$set = new HashSet();

		$this->assertCount(0, $set);

		$set->add(4);
		$set->add(7);
		$set->add(0);

		$this->assertCount(3, $set);
	}

	public function testContainsValueNotFound()
	{
		$set = new HashSet([4, 5]);

		$this->assertFalse($set->contains(6));
	}

	public function testContains()
	{
		$set = new HashSet([4, 5]);

		$this->assertTrue($set->contains(5));		
	}

	public function testRemoveValueNotFound()
	{
		$set = new HashSet([1, 2, 3, 4, 5, 6]);

		$this->assertCount(6, $set);

		$set->remove(9);

		$this->assertCount(6, $set);
	}

	public function testRemove()
	{
		$set = new HashSet([1, 2, 3, 4, 5, 6]);

		$this->assertTrue($set->contains(4));
		$this->assertCount(6, $set);

		$set->remove(4);

		$this->assertFalse($set->contains(4));
		$this->assertCount(5, $set);
	}
}