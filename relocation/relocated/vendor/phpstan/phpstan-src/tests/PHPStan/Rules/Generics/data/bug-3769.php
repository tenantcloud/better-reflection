<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3769;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
/**
 * @template K of array-key
 * @param array<K, int> $in
 * @return array<K, string>
 */
function stringValues(array $in) : array
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<K of (int|string) (function Bug3769\\stringValues(), argument), int>', $in);
    return \array_map(function (int $int) : string {
        return (string) $int;
    }, $in);
}
/**
 * @param array<int, int> $foo
 * @param array<string, int> $bar
 * @param array<int> $baz
 */
function foo(array $foo, array $bar, array $baz) : void
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, string>', stringValues($foo));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string, string>', stringValues($bar));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string>', stringValues($baz));
}
/**
 * @template T of \stdClass|\Exception
 * @param T $foo
 */
function fooUnion($foo) : void
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T of Exception|stdClass (function Bug3769\\fooUnion(), argument)', $foo);
}
/**
 * @template T
 * @param T $a
 * @return T
 */
function mixedBound($a)
{
    return $a;
}
/**
 * @template T of int
 * @param T $a
 * @return T
 */
function intBound(int $a)
{
    return $a;
}
/**
 * @template T of string
 * @param T $a
 * @return T
 */
function stringBound(string $a)
{
    return $a;
}
function () : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', mixedBound(1));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('string', mixedBound('str'));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('1', intBound(1));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'str\'', stringBound('str'));
};
/** @template T of string */
class Foo
{
    /** @var T */
    private $value;
    /**
     * @param T $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }
    /**
     * @return T
     */
    public function getValue()
    {
        return $this->value;
    }
}
/** @param Foo<'bar'> $foo */
function testTofString(\TenantCloud\BetterReflection\Relocated\Bug3769\Foo $foo) : void
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'bar\'', $foo->getValue());
    $baz = new \TenantCloud\BetterReflection\Relocated\Bug3769\Foo('baz');
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('\'baz\'', $baz->getValue());
}
