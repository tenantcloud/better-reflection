<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
interface TypeWithClassName extends \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
{
    public function getClassName() : string;
    public function getAncestorWithClassName(string $className) : ?self;
    public function getClassReflection() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
}
