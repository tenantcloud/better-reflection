<?php

namespace TenantCloud\BetterReflection\Relocated\MethodReturnStatic;

class A
{
    /** @return static */
    public function returnStatic()
    {
    }
}
class B extends \TenantCloud\BetterReflection\Relocated\MethodReturnStatic\A
{
    /** @return static */
    public function test()
    {
        return $this->returnStatic();
    }
}
final class B2 extends \TenantCloud\BetterReflection\Relocated\MethodReturnStatic\A
{
    /** @return static */
    public function test()
    {
        return $this->returnStatic();
    }
}
