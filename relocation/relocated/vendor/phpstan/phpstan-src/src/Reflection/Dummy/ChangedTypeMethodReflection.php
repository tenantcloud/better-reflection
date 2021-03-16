<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Dummy;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor;
use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class ChangedTypeMethodReflection implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $declaringClass;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $reflection;
    /** @var ParametersAcceptor[] */
    private array $variants;
    /**
     * @param MethodReflection $reflection
     * @param ParametersAcceptor[] $variants
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $declaringClass, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $reflection, array $variants)
    {
        $this->declaringClass = $declaringClass;
        $this->reflection = $reflection;
        $this->variants = $variants;
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
    public function getName() : string
    {
        return $this->reflection->getName();
    }
    public function getPrototype() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberReflection
    {
        return $this->reflection->getPrototype();
    }
    public function getVariants() : array
    {
        return $this->variants;
    }
    public function isDeprecated() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->reflection->isDeprecated();
    }
    public function getDeprecatedDescription() : ?string
    {
        return $this->reflection->getDeprecatedDescription();
    }
    public function isFinal() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->reflection->isFinal();
    }
    public function isInternal() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->reflection->isInternal();
    }
    public function getThrowType() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->reflection->getThrowType();
    }
    public function hasSideEffects() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->reflection->hasSideEffects();
    }
}
