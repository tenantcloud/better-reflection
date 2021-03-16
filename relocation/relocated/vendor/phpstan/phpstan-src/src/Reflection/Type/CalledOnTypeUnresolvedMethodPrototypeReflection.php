<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Dummy\ChangedTypeMethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionVariant;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParameterReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\DummyParameter;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ResolvedMethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser;
class CalledOnTypeUnresolvedMethodPrototypeReflection implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedMethodPrototypeReflection
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $methodReflection;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $resolvedDeclaringClass;
    private bool $resolveTemplateTypeMapToBounds;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $calledOnType;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $methodReflection, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $resolvedDeclaringClass, bool $resolveTemplateTypeMapToBounds, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $calledOnType)
    {
        $this->methodReflection = $methodReflection;
        $this->resolvedDeclaringClass = $resolvedDeclaringClass;
        $this->resolveTemplateTypeMapToBounds = $resolveTemplateTypeMapToBounds;
        $this->calledOnType = $calledOnType;
    }
    public function doNotResolveTemplateTypeMapToBounds() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedMethodPrototypeReflection
    {
        return new self($this->methodReflection, $this->resolvedDeclaringClass, \false, $this->calledOnType);
    }
    public function getNakedMethod() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
    {
        return $this->methodReflection;
    }
    public function getTransformedMethod() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
    {
        $templateTypeMap = $this->resolvedDeclaringClass->getActiveTemplateTypeMap();
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ResolvedMethodReflection($this->transformMethodWithStaticType($this->resolvedDeclaringClass, $this->methodReflection), $this->resolveTemplateTypeMapToBounds ? $templateTypeMap->resolveToBounds() : $templateTypeMap);
    }
    public function withCalledOnType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedMethodPrototypeReflection
    {
        return new self($this->methodReflection, $this->resolvedDeclaringClass, $this->resolveTemplateTypeMapToBounds, $type);
    }
    private function transformMethodWithStaticType(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $declaringClass, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $method) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
    {
        $variants = \array_map(function (\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptor $acceptor) : ParametersAcceptor {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionVariant($acceptor->getTemplateTypeMap(), $acceptor->getResolvedTemplateTypeMap(), \array_map(function (\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParameterReflection $parameter) : ParameterReflection {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\DummyParameter($parameter->getName(), $this->transformStaticType($parameter->getType()), $parameter->isOptional(), $parameter->passedByReference(), $parameter->isVariadic(), $parameter->getDefaultValue());
            }, $acceptor->getParameters()), $acceptor->isVariadic(), $this->transformStaticType($acceptor->getReturnType()));
        }, $method->getVariants());
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Dummy\ChangedTypeMethodReflection($declaringClass, $method, $variants);
    }
    private function transformStaticType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser::map($type, function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, callable $traverse) : Type {
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StaticType) {
                return $this->calledOnType;
            }
            return $traverse($type);
        });
    }
}
