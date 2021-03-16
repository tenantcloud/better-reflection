<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedMethodPrototypeReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClosureType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class ClosureCallUnresolvedMethodPrototypeReflection implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedMethodPrototypeReflection
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedMethodPrototypeReflection $prototype;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClosureType $closure;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedMethodPrototypeReflection $prototype, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ClosureType $closure)
    {
        $this->prototype = $prototype;
        $this->closure = $closure;
    }
    public function doNotResolveTemplateTypeMapToBounds() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedMethodPrototypeReflection
    {
        return new self($this->prototype->doNotResolveTemplateTypeMapToBounds(), $this->closure);
    }
    public function getNakedMethod() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
    {
        return $this->getTransformedMethod();
    }
    public function getTransformedMethod() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\ClosureCallMethodReflection($this->prototype->getTransformedMethod(), $this->closure);
    }
    public function withCalledOnType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedMethodPrototypeReflection
    {
        return new self($this->prototype->withCalledOnType($type), $this->closure);
    }
}
