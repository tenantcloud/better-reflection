<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4648;

interface ClassInterface
{
    /**
     * @return static
     */
    public static function convert();
}
trait ClassDefaultLogic
{
    /**
     * @return static
     */
    public static function convert()
    {
        return new self();
    }
}
final class ClassImplementation implements \TenantCloud\BetterReflection\Relocated\Bug4648\ClassInterface
{
    use ClassDefaultLogic;
}
