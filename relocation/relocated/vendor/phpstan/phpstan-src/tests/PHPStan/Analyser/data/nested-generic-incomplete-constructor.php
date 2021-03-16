<?php

namespace TenantCloud\BetterReflection\Relocated\NestedGenericIncompleteConstructor;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
/**
 * @template T
 * @template U of T
 */
class Foo
{
    /** @var T */
    public $t;
    /** @var U */
    public $u;
    /**
     * @param T $t
     */
    public function __construct($t)
    {
    }
}
function () : void {
    $foo = new \TenantCloud\BetterReflection\Relocated\NestedGenericIncompleteConstructor\Foo(1);
    //assertType('NestedGenericIncompleteConstructor\Foo<int, int>', $foo);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $foo->t);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $foo->u);
};
