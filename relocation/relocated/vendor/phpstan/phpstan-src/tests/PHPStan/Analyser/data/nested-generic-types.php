<?php

namespace TenantCloud\BetterReflection\Relocated\NestedGenericTypes;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
/** @template T */
interface SomeInterface
{
}
/**
 * @template T of SomeInterface<T>
 * @template TT of SomeInterface<U>
 * @template U
 * @template V of SomeInterface<U>
 */
class Foo
{
    /** @var T */
    public $t;
    /** @var TT */
    public $tt;
    /** @var U */
    public $u;
    /** @var V */
    public $v;
    public function doFoo() : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T of NestedGenericTypes\\SomeInterface<NestedGenericTypes\\T> (class NestedGenericTypes\\Foo, argument)', $this->t);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TT of NestedGenericTypes\\SomeInterface<U (class NestedGenericTypes\\Foo, argument)> (class NestedGenericTypes\\Foo, argument)', $this->tt);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('U (class NestedGenericTypes\\Foo, argument)', $this->u);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('V of NestedGenericTypes\\SomeInterface<U (class NestedGenericTypes\\Foo, argument)> (class NestedGenericTypes\\Foo, argument)', $this->v);
    }
}
/**
 * @template T of SomeInterface<T>
 * @template TT of SomeInterface<U>
 * @template U
 * @template V of SomeInterface<U>
 * @param T $t
 * @param TT $tt
 * @param U $u
 * @param V $v
 */
function testFoo($t, $tt, $u, $v) : void
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T of NestedGenericTypes\\SomeInterface<NestedGenericTypes\\T> (function NestedGenericTypes\\testFoo(), argument)', $t);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TT of NestedGenericTypes\\SomeInterface<U (function NestedGenericTypes\\testFoo(), argument)> (function NestedGenericTypes\\testFoo(), argument)', $tt);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('U (function NestedGenericTypes\\testFoo(), argument)', $u);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('V of NestedGenericTypes\\SomeInterface<U (function NestedGenericTypes\\testFoo(), argument)> (function NestedGenericTypes\\testFoo(), argument)', $v);
}
/** @template T */
interface SomeFoo
{
}
/** @template T */
interface SomeBar
{
}
/**
 * @template T
 * @template U of SomeFoo<T>
 * @param U $foo
 * @return U
 */
function testSome($foo)
{
}
/**
 * @template T
 * @template U of SomeFoo<T>
 * @param U $foo
 * @return T
 */
function testSomeUnwrap($foo)
{
}
function (\TenantCloud\BetterReflection\Relocated\NestedGenericTypes\SomeFoo $foo) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('NestedGenericTypes\\SomeFoo<mixed>', testSome($foo));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', testSomeUnwrap($foo));
};
function (\TenantCloud\BetterReflection\Relocated\NestedGenericTypes\SomeBar $bar) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('NestedGenericTypes\\SomeFoo<mixed>', testSome($bar));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', testSomeUnwrap($bar));
};
/**
 * @param SomeFoo<string> $foo
 */
function testSome2($foo)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('NestedGenericTypes\\SomeFoo<string>', testSome($foo));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', testSomeUnwrap($foo));
}
/**
 * @param SomeBar<string> $bar
 */
function testSome3($bar)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('NestedGenericTypes\\SomeFoo<mixed>', testSome($bar));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', testSomeUnwrap($bar));
}
/**
 * @template T
 * @return T
 */
function unwrapWithoutParam()
{
}
function () : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('mixed', unwrapWithoutParam());
};
/**
 * @template T of SomeFoo<U>
 * @template U
 * @return T
 */
function unwrapGenericWithoutParam()
{
}
function () : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('NestedGenericTypes\\SomeFoo<mixed>', unwrapGenericWithoutParam());
};
/**
 * @template T of SomeFoo
 * @param T $t
 * @return T
 */
function nonGenericBoundOfGenericClass($t)
{
    return $t;
}
function (\TenantCloud\BetterReflection\Relocated\NestedGenericTypes\SomeFoo $foo, \TenantCloud\BetterReflection\Relocated\NestedGenericTypes\SomeBar $bar) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\NestedGenericTypes\SomeFoo::class, nonGenericBoundOfGenericClass($foo));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\NestedGenericTypes\SomeFoo::class, nonGenericBoundOfGenericClass($bar));
};
