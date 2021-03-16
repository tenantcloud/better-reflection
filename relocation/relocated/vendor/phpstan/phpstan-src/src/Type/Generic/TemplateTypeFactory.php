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
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
final class TemplateTypeFactory
{
    public static function create(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope $scope, string $name, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $bound, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance $variance) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType
    {
        $strategy = new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeParameterStrategy();
        if ($bound === null) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateMixedType($scope, $strategy, $variance, $name, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true));
        }
        $boundClass = \get_class($bound);
        if ($bound instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType && ($boundClass === \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType::class || $bound instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType)) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateObjectType($scope, $strategy, $variance, $name, $bound);
        }
        if ($bound instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType && ($boundClass === \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType::class || $bound instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType)) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateGenericObjectType($scope, $strategy, $variance, $name, $bound);
        }
        if ($bound instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType && ($boundClass === \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType::class || $bound instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType)) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateObjectWithoutClassType($scope, $strategy, $variance, $name, $bound);
        }
        if ($bound instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType && ($boundClass === \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType::class || $bound instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType)) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateStringType($scope, $strategy, $variance, $name, $bound);
        }
        if ($bound instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType && ($boundClass === \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType::class || $bound instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType)) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateIntegerType($scope, $strategy, $variance, $name, $bound);
        }
        if ($bound instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType && ($boundClass === \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType::class || $bound instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType)) {
            return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateMixedType($scope, $strategy, $variance, $name, $bound);
        }
        if ($bound instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType) {
            if ($boundClass === \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType::class || $bound instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateUnionType) {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateUnionType($scope, $strategy, $variance, $name, $bound);
            }
            if ($bound instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType) {
                return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateBenevolentUnionType($scope, $strategy, $variance, $name, $bound);
            }
        }
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateMixedType($scope, $strategy, $variance, $name, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType(\true));
    }
    public static function fromTemplateTag(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope $scope, \TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\TemplateTag $tag) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType
    {
        return self::create($scope, $tag->getName(), $tag->getBound(), $tag->getVariance());
    }
}
