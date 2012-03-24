<?php

namespace Collection\Assert;

use BadMethodCallException;

class Method
{
	private function __construct()
	{
	}

	public static function notImplemented($methodName)
	{
		throw new BadMethodCallException(sprintf('Method %s is not implemented'));
	}
}