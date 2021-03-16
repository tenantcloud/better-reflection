<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3120;

class A
{
    /** @return static */
    public static function getInstance()
    {
        $class = static::class;
        return new $class();
    }
}
final class AChild extends \TenantCloud\BetterReflection\Relocated\Bug3120\A
{
    public static function getInstance()
    {
        return new \TenantCloud\BetterReflection\Relocated\Bug3120\AChild();
    }
}
class Test
{
    public final function __construct()
    {
    }
    /**
     * @return static
     */
    public function foo() : self
    {
        return self::bar(new static());
    }
    /**
     * @phpstan-template T of Test
     * @phpstan-param T $object
     * @phpstan-return T
     */
    public function bar(\TenantCloud\BetterReflection\Relocated\Bug3120\Test $object) : self
    {
        return $object;
    }
}
