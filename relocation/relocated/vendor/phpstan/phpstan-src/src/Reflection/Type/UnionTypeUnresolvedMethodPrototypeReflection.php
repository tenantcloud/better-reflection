<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class UnionTypeUnresolvedMethodPrototypeReflection implements \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedMethodPrototypeReflection
{
    private string $methodName;
    /** @var UnresolvedMethodPrototypeReflection[] */
    private array $methodPrototypes;
    /**
     * @param UnresolvedMethodPrototypeReflection[] $methodPrototypes
     */
    public function __construct(string $methodName, array $methodPrototypes)
    {
        $this->methodName = $methodName;
        $this->methodPrototypes = $methodPrototypes;
    }
    public function doNotResolveTemplateTypeMapToBounds() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedMethodPrototypeReflection
    {
        return new self($this->methodName, \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedMethodPrototypeReflection $prototype) : UnresolvedMethodPrototypeReflection {
            return $prototype->doNotResolveTemplateTypeMapToBounds();
        }, $this->methodPrototypes));
    }
    public function getNakedMethod() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
    {
        return $this->getTransformedMethod();
    }
    public function getTransformedMethod() : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection
    {
        $methods = \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedMethodPrototypeReflection $prototype) : MethodReflection {
            return $prototype->getTransformedMethod();
        }, $this->methodPrototypes);
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnionTypeMethodReflection($this->methodName, $methods);
    }
    public function withCalledOnType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedMethodPrototypeReflection
    {
        return new self($this->methodName, \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Type\UnresolvedMethodPrototypeReflection $prototype) use($type) : UnresolvedMethodPrototypeReflection {
            return $prototype->withCalledOnType($type);
        }, $this->methodPrototypes));
    }
}
