<?php

namespace TenantCloud\BetterReflection\Relocated\GenericTraits;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
trait FooTrait
{
    /**
     * @param T $t
     * @return T
     */
    public function doFoo($t)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\GenericTraits\\T', $t);
    }
}
/** @template T */
class Foo
{
    use FooTrait;
    public function doBar() : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\GenericTraits\\T', $this->doFoo(1));
    }
}
/** @template T of object */
trait BarTrait
{
    /**
     * @param T $t
     * @return T
     */
    public function doFoo($t)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('object', $t);
    }
}
/** @template T */
class Bar
{
    use BarTrait;
    public function doBar() : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('object', $this->doFoo());
    }
}
/** @template T of object */
trait Bar2Trait
{
    /**
     * @param T $t
     * @return T
     */
    public function doFoo($t)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('object', $t);
    }
}
/** @template U */
class Bar2
{
    use Bar2Trait;
    public function doBar() : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('object', $this->doFoo());
    }
}
/** @template T of object */
trait Bar3Trait
{
    /**
     * @param T $t
     * @return T
     */
    public function doFoo($t)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('stdClass', $t);
    }
}
class Bar3
{
    /** @use Bar3Trait<\stdClass> */
    use Bar3Trait;
    public function doBar() : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('stdClass', $this->doFoo());
    }
}
/** @template T of object */
trait Bar4Trait
{
    /**
     * @param T $t
     * @return T
     */
    public function doFoo($t)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('U (class GenericTraits\\Bar4, argument)', $t);
    }
}
/** @template U */
class Bar4
{
    /** @use Bar4Trait<U> */
    use Bar4Trait;
    public function doBar() : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('U (class GenericTraits\\Bar4, argument)', $this->doFoo());
    }
}
/** @template T of object */
trait Bar5Trait
{
    /**
     * @param T $t
     * @return T
     */
    public function doFoo($t)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T (class GenericTraits\\Bar5, argument)', $t);
    }
}
/** @template T */
class Bar5
{
    /** @use Bar5Trait<T> */
    use Bar5Trait;
    public function doBar() : void
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T (class GenericTraits\\Bar5, argument)', $this->doFoo());
    }
    // sanity checks below (is T supposed to be an argument? yes)
    /**
     * @param T $t
     */
    public function doBaz($t)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T (class GenericTraits\\Bar5, argument)', $t);
    }
    /**
     * @return T
     */
    public function returnT()
    {
    }
    public function doLorem()
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('T (class GenericTraits\\Bar5, argument)', $this->returnT());
    }
}
/** @template T */
trait Bar6Trait
{
    /** @param T $t */
    public function doFoo($t)
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('int', $t);
    }
}
/** @template U */
trait Bar7Trait
{
    /** @use Bar6Trait<U> */
    use Bar6Trait;
}
class Bar7
{
    /** @use Bar7Trait<int> */
    use Bar7Trait;
}
