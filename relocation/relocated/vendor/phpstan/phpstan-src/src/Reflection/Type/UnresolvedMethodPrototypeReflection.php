<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
interface UnresolvedMethodPrototypeReflection
{
    public function doNotResolveTemplateTypeMapToBounds() : self;
    public function getNakedMethod() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
    public function getTransformedMethod() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
    public function withCalledOnType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : self;
}
