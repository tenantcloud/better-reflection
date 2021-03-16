<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4247;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class HelloWorld
{
    /**
     * @return static
     */
    public function singleton()
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('static(Bug4247\\HelloWorld)', \TenantCloud\BetterReflection\Relocated\Bug4247\SingletonLib::init(static::class));
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Bug4247\\HelloWorld', \TenantCloud\BetterReflection\Relocated\Bug4247\SingletonLib::init(self::class));
    }
}
final class SingletonLib
{
    /**
     * @template       TInit
     * @param  class-string<TInit> $classname
     * @return TInit
     */
    public static function init($classname)
    {
    }
}
