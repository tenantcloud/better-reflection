<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Dummy\ChangedTypePropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ResolvedPropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class CallbackUnresolvedPropertyPrototypeReflection implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedPropertyPrototypeReflection
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection $propertyReflection;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $resolvedDeclaringClass;
    private bool $resolveTemplateTypeMapToBounds;
    /** @var callable(Type): Type */
    private $transformStaticTypeCallback;
    /**
     * @param PropertyReflection $propertyReflection
     * @param ClassReflection $resolvedDeclaringClass
     * @param bool $resolveTemplateTypeMapToBounds
     * @param callable(Type): Type $transformStaticTypeCallback
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection $propertyReflection, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $resolvedDeclaringClass, bool $resolveTemplateTypeMapToBounds, callable $transformStaticTypeCallback)
    {
        $this->propertyReflection = $propertyReflection;
        $this->resolvedDeclaringClass = $resolvedDeclaringClass;
        $this->resolveTemplateTypeMapToBounds = $resolveTemplateTypeMapToBounds;
        $this->transformStaticTypeCallback = $transformStaticTypeCallback;
    }
    public function doNotResolveTemplateTypeMapToBounds() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedPropertyPrototypeReflection
    {
        return new self($this->propertyReflection, $this->resolvedDeclaringClass, \false, $this->transformStaticTypeCallback);
    }
    public function getNakedProperty() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection
    {
        return $this->propertyReflection;
    }
    public function getTransformedProperty() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection
    {
        $templateTypeMap = $this->resolvedDeclaringClass->getActiveTemplateTypeMap();
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ResolvedPropertyReflection($this->transformPropertyWithStaticType($this->resolvedDeclaringClass, $this->propertyReflection), $this->resolveTemplateTypeMapToBounds ? $templateTypeMap->resolveToBounds() : $templateTypeMap);
    }
    public function withFechedOnType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedPropertyPrototypeReflection
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\CalledOnTypeUnresolvedPropertyPrototypeReflection($this->propertyReflection, $this->resolvedDeclaringClass, $this->resolveTemplateTypeMapToBounds, $type);
    }
    protected function transformPropertyWithStaticType(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $declaringClass, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection $property) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection
    {
        $readableType = $this->transformStaticType($property->getReadableType());
        $writableType = $this->transformStaticType($property->getWritableType());
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Dummy\ChangedTypePropertyReflection($declaringClass, $property, $readableType, $writableType);
    }
    private function transformStaticType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $callback = $this->transformStaticTypeCallback;
        return $callback($type);
    }
}
