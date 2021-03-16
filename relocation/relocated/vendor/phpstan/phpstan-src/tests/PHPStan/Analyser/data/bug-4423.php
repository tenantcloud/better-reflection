<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Bug4423;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
/**
 * @template T
 */
class Bar
{
}
/**
 * @template K
 * @property-read Bar<K> $bar
 * @method Bar<K> doBar()
 */
trait Foo
{
    /** @var Bar<K> */
    public $baz;
    /** @param K $k */
    public function doFoo($k)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T (class Bug4423\\Child, argument)', $k);
        //assertType('Bug4423\Bar<T (class Bug4423\Child, argument)>', $this->bar);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Bug4423\\Bar<T (class Bug4423\\Child, argument)>', $this->baz);
        //assertType('Bug4423\Bar<T (class Bug4423\Child, argument)>', $this->doBar());
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Bug4423\\Bar<T (class Bug4423\\Child, argument)>', $this->doBaz());
    }
    /** @return Bar<K> */
    public function doBaz()
    {
    }
}
/**
 * @template T
 * @template K
 */
class Base
{
}
/**
 * @template T
 * @extends Base<int, T>
 */
class Child extends \TenantCloud\BetterReflection\Relocated\Bug4423\Base
{
    /** @phpstan-use Foo<T> */
    use Foo;
}
function (\TenantCloud\BetterReflection\Relocated\Bug4423\Child $child) : void {
    /** @var Child<int> $child */
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Bug4423\\Child<int>', $child);
    //assertType('Bug4423\Bar<int>', $child->bar);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Bug4423\\Bar<int>', $child->baz);
    //assertType('Bug4423\Bar<int>', $child->doBar());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Bug4423\\Bar<int>', $child->doBaz());
};
