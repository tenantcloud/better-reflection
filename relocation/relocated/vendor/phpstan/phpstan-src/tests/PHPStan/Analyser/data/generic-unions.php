<?php

namespace TenantCloud\BetterReflection\Relocated\GenericUnions;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @template T
     * @param T|null $p
     * @return T
     */
    public function doFoo($p)
    {
        if ($p === null) {
            throw new \Exception();
        }
        return $p;
    }
    /**
     * @template T
     * @param T $p
     * @return T
     */
    public function doBar($p)
    {
        return $p;
    }
    /**
     * @template T
     * @param T|int|float $p
     * @return T
     */
    public function doBaz($p)
    {
        return $p;
    }
    /**
     * @param int|string $stringOrInt
     */
    public function foo(?string $nullableString, $stringOrInt) : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $this->doFoo($nullableString));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int|string', $this->doFoo($stringOrInt));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string|null', $this->doBar($nullableString));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $this->doBaz(1));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $this->doBaz('foo'));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('float', $this->doBaz(1.2));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', $this->doBaz($stringOrInt));
    }
}
