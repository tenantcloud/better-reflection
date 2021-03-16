<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class IntersectionTypeUnresolvedPropertyPrototypeReflection implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedPropertyPrototypeReflection
{
    private string $propertyName;
    /** @var UnresolvedPropertyPrototypeReflection[] */
    private array $propertyPrototypes;
    /**
     * @param UnresolvedPropertyPrototypeReflection[] $propertyPrototypes
     */
    public function __construct(string $propertyName, array $propertyPrototypes)
    {
        $this->propertyName = $propertyName;
        $this->propertyPrototypes = $propertyPrototypes;
    }
    public function doNotResolveTemplateTypeMapToBounds() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedPropertyPrototypeReflection
    {
        return new self($this->propertyName, \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedPropertyPrototypeReflection $prototype) : UnresolvedPropertyPrototypeReflection {
            return $prototype->doNotResolveTemplateTypeMapToBounds();
        }, $this->propertyPrototypes));
    }
    public function getNakedProperty() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection
    {
        return $this->getTransformedProperty();
    }
    public function getTransformedProperty() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection
    {
        $properties = \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedPropertyPrototypeReflection $prototype) : PropertyReflection {
            return $prototype->getTransformedProperty();
        }, $this->propertyPrototypes);
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\IntersectionTypePropertyReflection($properties);
    }
    public function withFechedOnType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedPropertyPrototypeReflection
    {
        return new self($this->propertyName, \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedPropertyPrototypeReflection $prototype) use($type) : UnresolvedPropertyPrototypeReflection {
            return $prototype->withFechedOnType($type);
        }, $this->propertyPrototypes));
    }
}
