<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ConstantReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\CallbackUnresolvedMethodPrototypeReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\CallbackUnresolvedPropertyPrototypeReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedMethodPrototypeReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedPropertyPrototypeReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits\NonGenericTypeTrait;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits\UndecidedComparisonTypeTrait;
class StaticType implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName
{
    use NonGenericTypeTrait;
    use UndecidedComparisonTypeTrait;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $classReflection;
    private ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType $staticObjectType = null;
    private string $baseClass;
    /**
     * @param string|ClassReflection $classReflection
     */
    public function __construct($classReflection)
    {
        if (\is_string($classReflection)) {
            $broker = \TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker::getInstance();
            if ($broker->hasClass($classReflection)) {
                $classReflection = $broker->getClass($classReflection);
                $this->classReflection = $classReflection;
                $this->baseClass = $classReflection->getName();
                return;
            }
            $this->classReflection = null;
            $this->baseClass = $classReflection;
            return;
        }
        $this->classReflection = $classReflection;
        $this->baseClass = $classReflection->getName();
    }
    public function getClassName() : string
    {
        return $this->baseClass;
    }
    public function getClassReflection() : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection
    {
        return $this->classReflection;
    }
    public function getAncestorWithClassName(string $className) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName
    {
        $ancestor = $this->getStaticObjectType()->getAncestorWithClassName($className);
        if ($ancestor === null) {
            return null;
        }
        return $this->changeBaseClass($ancestor->getClassReflection() ?? $ancestor->getClassName());
    }
    public function getStaticObjectType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType
    {
        if ($this->staticObjectType === null) {
            if ($this->classReflection !== null && $this->classReflection->isGeneric()) {
                $typeMap = $this->classReflection->getActiveTemplateTypeMap()->map(static function (string $name, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : Type {
                    return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper::toArgument($type);
                });
                return $this->staticObjectType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType($this->classReflection->getName(), $this->classReflection->typeMapToList($typeMap));
            }
            return $this->staticObjectType = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType($this->baseClass, null, $this->classReflection);
        }
        return $this->staticObjectType;
    }
    /**
     * @return string[]
     */
    public function getReferencedClasses() : array
    {
        return $this->getStaticObjectType()->getReferencedClasses();
    }
    public function getBaseClass() : string
    {
        return $this->baseClass;
    }
    public function accepts(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, bool $strictTypes) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundTypeHelper::accepts($type, $this, $strictTypes);
        }
        if (!$type instanceof static) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
        }
        return $this->getStaticObjectType()->accepts($type->getStaticObjectType(), $strictTypes);
    }
    public function isSuperTypeOf(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        if ($type instanceof self) {
            return $this->getStaticObjectType()->isSuperTypeOf($type);
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType) {
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe();
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType) {
            $result = $this->getStaticObjectType()->isSuperTypeOf($type);
            $classReflection = $type->getClassReflection();
            if ($result->yes() && $classReflection !== null && $classReflection->isFinal()) {
                return $result;
            }
            return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createMaybe()->and($result);
        }
        if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\CompoundType) {
            return $type->isSubTypeOf($this);
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createNo();
    }
    public function equals(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : bool
    {
        if (\get_class($type) !== static::class) {
            return \false;
        }
        /** @var StaticType $type */
        $type = $type;
        return $this->getStaticObjectType()->equals($type->getStaticObjectType());
    }
    public function describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel $level) : string
    {
        return \sprintf('static(%s)', $this->getClassName());
    }
    public function canAccessProperties() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->canAccessProperties();
    }
    public function hasProperty(string $propertyName) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->hasProperty($propertyName);
    }
    public function getProperty(string $propertyName, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection
    {
        return $this->getUnresolvedPropertyPrototype($propertyName, $scope)->getTransformedProperty();
    }
    public function getUnresolvedPropertyPrototype(string $propertyName, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedPropertyPrototypeReflection
    {
        $staticObject = $this->getStaticObjectType();
        $nakedProperty = $staticObject->getUnresolvedPropertyPrototype($propertyName, $scope)->getNakedProperty();
        $ancestor = $this->getAncestorWithClassName($nakedProperty->getDeclaringClass()->getName());
        $classReflection = null;
        if ($ancestor !== null) {
            $classReflection = $ancestor->getClassReflection();
        }
        if ($classReflection === null) {
            $classReflection = $nakedProperty->getDeclaringClass();
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\CallbackUnresolvedPropertyPrototypeReflection($nakedProperty, $classReflection, \false, function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($scope) : Type {
            return $this->transformStaticType($type, $scope);
        });
    }
    public function canCallMethods() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->canCallMethods();
    }
    public function hasMethod(string $methodName) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->hasMethod($methodName);
    }
    public function getMethod(string $methodName, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
    {
        return $this->getUnresolvedMethodPrototype($methodName, $scope)->getTransformedMethod();
    }
    public function getUnresolvedMethodPrototype(string $methodName, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedMethodPrototypeReflection
    {
        $staticObject = $this->getStaticObjectType();
        $nakedMethod = $staticObject->getUnresolvedMethodPrototype($methodName, $scope)->getNakedMethod();
        $ancestor = $this->getAncestorWithClassName($nakedMethod->getDeclaringClass()->getName());
        $classReflection = null;
        if ($ancestor !== null) {
            $classReflection = $ancestor->getClassReflection();
        }
        if ($classReflection === null) {
            $classReflection = $nakedMethod->getDeclaringClass();
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\CallbackUnresolvedMethodPrototypeReflection($nakedMethod, $classReflection, \false, function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) use($scope) : Type {
            return $this->transformStaticType($type, $scope);
        });
    }
    private function transformStaticType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser::map($type, function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, callable $traverse) use($scope) : Type {
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType) {
                $classReflection = $this->classReflection;
                $isFinal = \false;
                if ($classReflection === null) {
                    $classReflection = $this->baseClass;
                } elseif ($scope->isInClass()) {
                    $classReflection = $scope->getClassReflection();
                    $isFinal = $classReflection->isFinal();
                }
                $type = $type->changeBaseClass($classReflection);
                if (!$isFinal) {
                    return $type;
                }
                return $type->getStaticObjectType();
            }
            return $traverse($type);
        });
    }
    public function canAccessConstants() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->canAccessConstants();
    }
    public function hasConstant(string $constantName) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->hasConstant($constantName);
    }
    public function getConstant(string $constantName) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ConstantReflection
    {
        return $this->getStaticObjectType()->getConstant($constantName);
    }
    /**
     * @param ClassReflection|string $classReflection
     * @return self
     */
    public function changeBaseClass($classReflection) : self
    {
        return new self($classReflection);
    }
    public function isIterable() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->isIterable();
    }
    public function isIterableAtLeastOnce() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->isIterableAtLeastOnce();
    }
    public function getIterableKeyType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->getStaticObjectType()->getIterableKeyType();
    }
    public function getIterableValueType() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->getStaticObjectType()->getIterableValueType();
    }
    public function isOffsetAccessible() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->isOffsetAccessible();
    }
    public function hasOffsetValueType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->hasOffsetValueType($offsetType);
    }
    public function getOffsetValueType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->getStaticObjectType()->getOffsetValueType($offsetType);
    }
    public function setOffsetValueType(?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $offsetType, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $valueType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->getStaticObjectType()->setOffsetValueType($offsetType, $valueType);
    }
    public function isCallable() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->isCallable();
    }
    public function isArray() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->isArray();
    }
    public function isNumericString() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->getStaticObjectType()->isNumericString();
    }
    /**
     * @param \PHPStan\Reflection\ClassMemberAccessAnswerer $scope
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getCallableParametersAcceptors(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer $scope) : array
    {
        return $this->getStaticObjectType()->getCallableParametersAcceptors($scope);
    }
    public function isCloneable() : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
    }
    public function toNumber() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType();
    }
    public function toString() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this->getStaticObjectType()->toString();
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
        return $this->getStaticObjectType()->toArray();
    }
    public function toBoolean() : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BooleanType
    {
        return $this->getStaticObjectType()->toBoolean();
    }
    public function traverse(callable $cb) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return $this;
    }
    /**
     * @param mixed[] $properties
     * @return Type
     */
    public static function __set_state(array $properties) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return new self($properties['baseClass']);
    }
}
