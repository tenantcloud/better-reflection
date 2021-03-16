<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection;

interface WrapperPropertyReflection extends \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection
{
    public function getOriginalReflection() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection;
}
