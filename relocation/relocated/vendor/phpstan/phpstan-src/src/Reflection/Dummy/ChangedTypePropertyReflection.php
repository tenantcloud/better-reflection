<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Dummy;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\WrapperPropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class ChangedTypePropertyReflection implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\WrapperPropertyReflection
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $declaringClass;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection $reflection;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $readableType;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $writableType;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $declaringClass, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection $reflection, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $readableType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $writableType)
    {
        $this->declaringClass = $declaringClass;
        $this->reflection = $reflection;
        $this->readableType = $readableType;
        $this->writableType = $writableType;
    }
    public function getDeclaringClass() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection
    {
        return $this->declaringClass;
    }
    public function isStatic() : bool
    {
        return $this->reflection->isStatic();
    }
    public function isPrivate() : bool
    {
        return $this->reflection->isPrivate();
    }
    public function isPublic() : bool
    {
        return $this->reflection->isPublic();
    }
    public function getDocComment() : ?string
    {
        return $this->reflection->getDocComment();
    }
    public function getReadableType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->readableType;
    }
    public function getWritableType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->writableType;
    }
    public function canChangeTypeAfterAssignment() : bool
    {
        return $this->reflection->canChangeTypeAfterAssignment();
    }
    public function isReadable() : bool
    {
        return $this->reflection->isReadable();
    }
    public function isWritable() : bool
    {
        return $this->reflection->isWritable();
    }
    public function isDeprecated() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->reflection->isDeprecated();
    }
    public function getDeprecatedDescription() : ?string
    {
        return $this->reflection->getDeprecatedDescription();
    }
    public function isInternal() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->reflection->isInternal();
    }
    public function getOriginalReflection() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection
    {
        return $this->reflection;
    }
}
