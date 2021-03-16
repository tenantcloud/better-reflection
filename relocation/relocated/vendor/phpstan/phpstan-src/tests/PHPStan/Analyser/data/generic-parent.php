<?php

namespace TenantCloud\BetterReflection\Relocated\GenericParent;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
interface Animal
{
}
interface Dog extends \TenantCloud\BetterReflection\Relocated\GenericParent\Animal
{
}
/**
 * @template T of Animal
 */
class Foo
{
    /** @return T */
    public function getAnimal() : \TenantCloud\BetterReflection\Relocated\GenericParent\Animal
    {
    }
}
/** @extends Foo<Dog> */
class Bar extends \TenantCloud\BetterReflection\Relocated\GenericParent\Foo
{
    public function doFoo()
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\GenericParent\Dog::class, parent::getAnimal());
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\GenericParent\Dog::class, \TenantCloud\BetterReflection\Relocated\GenericParent\Foo::getAnimal());
    }
}
class E
{
}
/**
 * @template T of E
 */
class R
{
    /** @return T */
    function ret()
    {
        return $this->e;
    }
    // nonsense, to silence missing return
    function test() : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T of GenericParent\\E (class GenericParent\\R, argument)', self::ret());
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T of GenericParent\\E (class GenericParent\\R, argument)', $this->ret());
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T of GenericParent\\E (class GenericParent\\R, argument)', static::ret());
    }
}
