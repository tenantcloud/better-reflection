<?php

namespace TenantCloud\BetterReflection\Reflection\Attributes;

use Ds\Sequence;

/**
 * @extends Sequence<object>
 */
interface AttributeSequence extends Sequence
{
	public function has(string $className): bool;
}
