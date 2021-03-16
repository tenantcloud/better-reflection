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
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class CallbackUnresolvedMethodPrototypeReflection implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedMethodPrototypeReflection
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $methodReflection;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $resolvedDeclaringClass;
    private bool $resolveTemplateTypeMapToBounds;
    /** @var callable(Type): Type */
    private $transformStaticTypeCallback;
    /**
     * @param MethodReflection $methodReflection
     * @param ClassReflection $resolvedDeclaringClass
     * @param bool $resolveTemplateTypeMapToBounds
     * @param callable(Type): Type $transformStaticTypeCallback
     */
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection $methodReflection, \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection $resolvedDeclaringClass, bool $resolveTemplateTypeMapToBounds, callable $transformStaticTypeCallback)
    {
        $this->methodReflection = $methodReflection;
        $this->resolvedDeclaringClass = $resolvedDeclaringClass;
        $this->resolveTemplateTypeMapToBounds = $resolveTemplateTypeMapToBounds;
        $this->transformStaticTypeCallback = $transformStaticTypeCallback;
    }
    public function doNotResolveTemplateTypeMapToBounds() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedMethodPrototypeReflection
    {
        return new self($this->methodReflection, $this->resolvedDeclaringClass, \false, $this->transformStaticTypeCallback);
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
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\CalledOnTypeUnresolvedMethodPrototypeReflection($this->methodReflection, $this->resolvedDeclaringClass, $this->resolveTemplateTypeMapToBounds, $type);
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
        $callback = $this->transformStaticTypeCallback;
        return $callback($type);
    }
}
