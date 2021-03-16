<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic;

use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\TemplateTag;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
final class TemplateTypeFactory
{
    public static function create(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope $scope, string $name, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $bound, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance $variance) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType
    {
        $strategy = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeParameterStrategy();
        if ($bound === null) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateMixedType($scope, $strategy, $variance, $name);
        }
        $boundClass = \get_class($bound);
        if ($bound instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName && $boundClass === \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType::class) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateObjectType($scope, $strategy, $variance, $name, $bound->getClassName());
        }
        if ($bound instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType && $boundClass === \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType::class) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateGenericObjectType($scope, $strategy, $variance, $name, $bound->getClassName(), $bound->getTypes());
        }
        if ($boundClass === \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType::class) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateObjectWithoutClassType($scope, $strategy, $variance, $name);
        }
        if ($boundClass === \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType::class) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateStringType($scope, $strategy, $variance, $name);
        }
        if ($boundClass === \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType::class) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateIntegerType($scope, $strategy, $variance, $name);
        }
        if ($boundClass === \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType::class) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateMixedType($scope, $strategy, $variance, $name);
        }
        if ($bound instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType) {
            if ($boundClass === \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType::class) {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateUnionType($scope, $strategy, $variance, $bound->getTypes(), $name);
            }
            if ($boundClass === \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType::class) {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateBenevolentUnionType($scope, $strategy, $variance, $bound->getTypes(), $name);
            }
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateMixedType($scope, $strategy, $variance, $name);
    }
    public static function fromTemplateTag(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope $scope, \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\TemplateTag $tag) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType
    {
        return self::create($scope, $tag->getName(), $tag->getBound(), $tag->getVariance());
    }
}
