<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class UnionTypeUnresolvedPropertyPrototypeReflection implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedPropertyPrototypeReflection
{
    private string $propertyName;
    /** @var UnresolvedPropertyPrototypeReflection[] */
    private array $propertyPrototypes;
    /**
     * @param UnresolvedPropertyPrototypeReflection[] $propertyPrototypes
     */
    public function __construct(string $methodName, array $propertyPrototypes)
    {
        $this->propertyName = $methodName;
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
        $methods = \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedPropertyPrototypeReflection $prototype) : PropertyReflection {
            return $prototype->getTransformedProperty();
        }, $this->propertyPrototypes);
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnionTypePropertyReflection($methods);
    }
    public function withFechedOnType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedPropertyPrototypeReflection
    {
        return new self($this->propertyName, \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedPropertyPrototypeReflection $prototype) use($type) : UnresolvedPropertyPrototypeReflection {
            return $prototype->withFechedOnType($type);
        }, $this->propertyPrototypes));
    }
}
