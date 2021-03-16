<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ConstantReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Dummy\DummyConstantReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Dummy\DummyMethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Dummy\DummyPropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\CallbackUnresolvedMethodPrototypeReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\CallbackUnresolvedPropertyPrototypeReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedMethodPrototypeReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedPropertyPrototypeReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
trait ObjectTypeTrait
{
    use MaybeCallableTypeTrait;
    use MaybeIterableTypeTrait;
    use MaybeOffsetAccessibleTypeTrait;
    use TruthyBooleanTypeTrait;
    public function canAccessProperties() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
    }
    public function hasProperty(string $propertyName) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getProperty(string $propertyName, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection
    {
        return $this->getUnresolvedPropertyPrototype($propertyName, $scope)->getTransformedProperty();
    }
    public function getUnresolvedPropertyPrototype(string $propertyName, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedPropertyPrototypeReflection
    {
        $property = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Dummy\DummyPropertyReflection();
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\CallbackUnresolvedPropertyPrototypeReflection($property, $property->getDeclaringClass(), \false, static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
            return $type;
        });
    }
    public function canCallMethods() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
    }
    public function hasMethod(string $methodName) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getMethod(string $methodName, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
    {
        return $this->getUnresolvedMethodPrototype($methodName, $scope)->getTransformedMethod();
    }
    public function getUnresolvedMethodPrototype(string $methodName, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedMethodPrototypeReflection
    {
        $method = new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Dummy\DummyMethodReflection($methodName);
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\CallbackUnresolvedMethodPrototypeReflection($method, $method->getDeclaringClass(), \false, static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
            return $type;
        });
    }
    public function canAccessConstants() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
    }
    public function hasConstant(string $constantName) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
    }
    public function getConstant(string $constantName) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ConstantReflection
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Dummy\DummyConstantReflection($constantName);
    }
    public function isCloneable() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
    }
    public function isArray() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function isNumericString() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function toNumber() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
    }
    public function toString() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType();
    }
    public function toInteger() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
    }
    public function toFloat() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
    }
    public function toArray() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType(new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType());
    }
}
