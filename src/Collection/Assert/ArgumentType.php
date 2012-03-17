<?php

namespace Collection\Assert;

use Traversable;
use InvalidArgumentException;

class ArgumentType
{
	private function __construct()
	{
	}

	public static function isInstanceOf($typeName, $argument, $argumentPosition, $methodName)
	{
		if (in_array($typeName, ['string', 'int', 'integer', 'float', 'bool', 'boolean', 'array'], true)) {
			$type = gettype($argument);

			if ($type === $typeName) {
				return;
			}

			throw new InvalidArgumentException(sprintf('Argument %d of %s must be of type %s', $argumentPosition, $methodName, $typeName));
		}

		if (!$argument instanceof $typeName) {
			throw new InvalidArgumentException(sprintf('Argument %d to %s must be instance of %s', $argumentPosition, $methodName, $typeName));
		}
	}

	public static function isTraversableOrNull($argument, $argumentPosition, $methodName)
	{
		if ($argument === null) {
			return;
		}

		if (is_array($argument)) {
			return;
		}

		if ($argument instanceof Traversable) {
			return;
		}

		throw new InvalidArgumentException(sprintf('Argument %d to %s must be array or instance of Traversable', $argumentPosition, $methodName));
	}

	public static function notNull($argument, $argumentPosition, $methodName)
	{
		if ($argument === null) {
			throw new InvalidArgumentException(sprintf('Argument %d to %s must not be null', $argumentPosition, $methodName));
		}
	}
}