<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
interface UnresolvedPropertyPrototypeReflection
{
    public function doNotResolveTemplateTypeMapToBounds() : self;
    public function getNakedProperty() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection;
    public function getTransformedProperty() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection;
    public function withFechedOnType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : self;
}
