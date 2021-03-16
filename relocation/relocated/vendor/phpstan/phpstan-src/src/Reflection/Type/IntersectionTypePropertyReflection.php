<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator;
class IntersectionTypePropertyReflection implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection
{
    /** @var PropertyReflection[] */
    private array $properties;
    /**
     * @param \PHPStan\Reflection\PropertyReflection[] $properties
     */
    public function __construct(array $properties)
    {
        $this->properties = $properties;
    }
    public function getDeclaringClass() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection
    {
        return $this->properties[0]->getDeclaringClass();
    }
    public function isStatic() : bool
    {
        foreach ($this->properties as $property) {
            if ($property->isStatic()) {
                return \true;
            }
        }
        return \false;
    }
    public function isPrivate() : bool
    {
        foreach ($this->properties as $property) {
            if (!$property->isPrivate()) {
                return \false;
            }
        }
        return \true;
    }
    public function isPublic() : bool
    {
        foreach ($this->properties as $property) {
            if ($property->isPublic()) {
                return \true;
            }
        }
        return \false;
    }
    public function isDeprecated() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::maxMin(...\array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection $property) : TrinaryLogic {
            return $property->isDeprecated();
        }, $this->properties));
    }
    public function getDeprecatedDescription() : ?string
    {
        $descriptions = [];
        foreach ($this->properties as $property) {
            if (!$property->isDeprecated()->yes()) {
                continue;
            }
            $description = $property->getDeprecatedDescription();
            if ($description === null) {
                continue;
            }
            $descriptions[] = $description;
        }
        if (\count($descriptions) === 0) {
            return null;
        }
        return \implode(' ', $descriptions);
    }
    public function isInternal() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::maxMin(...\array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection $property) : TrinaryLogic {
            return $property->isInternal();
        }, $this->properties));
    }
    public function getDocComment() : ?string
    {
        return null;
    }
    public function getReadableType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::intersect(...\array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection $property) : Type {
            return $property->getReadableType();
        }, $this->properties));
    }
    public function getWritableType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeCombinator::intersect(...\array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection $property) : Type {
            return $property->getWritableType();
        }, $this->properties));
    }
    public function canChangeTypeAfterAssignment() : bool
    {
        foreach ($this->properties as $property) {
            if (!$property->canChangeTypeAfterAssignment()) {
                return \false;
            }
        }
        return \true;
    }
    public function isReadable() : bool
    {
        foreach ($this->properties as $property) {
            if (!$property->isReadable()) {
                return \false;
            }
        }
        return \true;
    }
    public function isWritable() : bool
    {
        foreach ($this->properties as $property) {
            if (!$property->isWritable()) {
                return \false;
            }
        }
        return \true;
    }
}
