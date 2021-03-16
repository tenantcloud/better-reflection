<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4213;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
abstract class BaseEnum
{
    /** @var string */
    private $value;
    private final function __construct(string $value)
    {
        $this->value = $value;
    }
    /**
     * @return static
     */
    public static function get(string $value) : self
    {
        return new static($value);
    }
}
final class Enum extends \TenantCloud\BetterReflection\Relocated\Bug4213\BaseEnum
{
}
final class Entity
{
    public function setEnums(\TenantCloud\BetterReflection\Relocated\Bug4213\Enum ...$enums) : void
    {
    }
    /**
     * @param Enum[] $enums
     */
    public function setEnumsWithoutSplat(array $enums) : void
    {
    }
}
function () : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Bug4213\\Enum', \TenantCloud\BetterReflection\Relocated\Bug4213\Enum::get('test'));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(Bug4213\\Enum)', \array_map([\TenantCloud\BetterReflection\Relocated\Bug4213\Enum::class, 'get'], ['test']));
};
class Foo
{
    /**
     * @return static
     */
    public static function create() : \TenantCloud\BetterReflection\Relocated\Bug4213\Foo
    {
        return new static();
    }
}
class Bar extends \TenantCloud\BetterReflection\Relocated\Bug4213\Foo
{
}
function () : void {
    $cbFoo = [\TenantCloud\BetterReflection\Relocated\Bug4213\Foo::class, 'create'];
    $cbBar = [\TenantCloud\BetterReflection\Relocated\Bug4213\Bar::class, 'create'];
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Bug4213\\Foo', $cbFoo());
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Bug4213\\Bar', $cbBar());
};
