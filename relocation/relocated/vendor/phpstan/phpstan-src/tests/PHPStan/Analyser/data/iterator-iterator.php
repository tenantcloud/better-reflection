<?php

namespace TenantCloud\BetterReflection\Relocated\IteratorIteratorTest;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param \ArrayIterator<int, string> $it
     */
    public function doFoo(\ArrayIterator $it) : void
    {
        $iteratorIterator = new \IteratorIterator($it);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Iterator<int, string>', $iteratorIterator->getInnerIterator());
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>', $iteratorIterator->getArrayCopy());
    }
}
