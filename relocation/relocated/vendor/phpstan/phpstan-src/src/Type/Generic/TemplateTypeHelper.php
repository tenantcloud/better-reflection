<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser;
class TemplateTypeHelper
{
    /**
     * Replaces template types with standin types
     */
    public static function resolveTemplateTypes(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap $standins) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser::map($type, static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, callable $traverse) use($standins) : Type {
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType && !$type->isArgument()) {
                $newType = $standins->getType($type->getName());
                if ($newType === null) {
                    return $traverse($type);
                }
                if ($newType instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType) {
                    return $traverse($type->getBound());
                }
                return $newType;
            }
            return $traverse($type);
        });
    }
    public static function resolveToBounds(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser::map($type, static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, callable $traverse) : Type {
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType) {
                return $traverse($type->getBound());
            }
            return $traverse($type);
        });
    }
    /**
     * @template T of Type
     * @param T $type
     * @return T
     */
    public static function toArgument(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        /** @var T */
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser::map($type, static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, callable $traverse) : Type {
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType) {
                return $traverse($type->toArgument());
            }
            return $traverse($type);
        });
    }
    public static function generalizeType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        return \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeTraverser::map($type, static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $type, callable $traverse) : Type {
            if ($type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ConstantType && !$type instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantArrayType) {
                return $type->generalize();
            }
            return $traverse($type);
        });
    }
}
