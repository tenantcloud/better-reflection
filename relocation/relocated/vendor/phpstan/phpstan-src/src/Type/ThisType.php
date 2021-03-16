<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
class ThisType extends \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType
{
    /**
     * @param ClassReflection|string $classReflection
     * @return self
     */
    public function changeBaseClass($classReflection) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType
    {
        return new self($classReflection);
    }
    public function describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel $level) : string
    {
        return \sprintf('$this(%s)', $this->getClassName());
    }
}
