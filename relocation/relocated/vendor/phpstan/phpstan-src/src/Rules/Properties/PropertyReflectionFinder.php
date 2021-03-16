<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\String_;
use TenantCloud\BetterReflection\Relocated\PhpParser\Node\VarLikeIdentifier;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils;
class PropertyReflectionFinder
{
    /**
     * @param \PhpParser\Node\Expr\PropertyFetch|\PhpParser\Node\Expr\StaticPropertyFetch $propertyFetch
     * @param \PHPStan\Analyser\Scope $scope
     * @return FoundPropertyReflection[]
     */
    public function findPropertyReflectionsFromNode($propertyFetch, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if ($propertyFetch instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch) {
            if ($propertyFetch->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier) {
                $names = [$propertyFetch->name->name];
            } else {
                $names = \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType $name) : string {
                    return $name->getValue();
                }, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($propertyFetch->name)));
            }
            $reflections = [];
            $propertyHolderType = $scope->getType($propertyFetch->var);
            foreach ($names as $name) {
                $reflection = $this->findPropertyReflection($propertyHolderType, $name, $propertyFetch->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr ? $scope->filterByTruthyValue(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Identical($propertyFetch->name, new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\String_($name))) : $scope);
                if ($reflection === null) {
                    continue;
                }
                $reflections[] = $reflection;
            }
            return $reflections;
        }
        if ($propertyFetch->class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name) {
            $propertyHolderType = $scope->resolveTypeByName($propertyFetch->class);
        } else {
            $propertyHolderType = $scope->getType($propertyFetch->class);
        }
        if ($propertyFetch->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\VarLikeIdentifier) {
            $names = [$propertyFetch->name->name];
        } else {
            $names = \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Constant\ConstantStringType $name) : string {
                return $name->getValue();
            }, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeUtils::getConstantStrings($scope->getType($propertyFetch->name)));
        }
        $reflections = [];
        foreach ($names as $name) {
            $reflection = $this->findPropertyReflection($propertyHolderType, $name, $propertyFetch->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr ? $scope->filterByTruthyValue(new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\BinaryOp\Identical($propertyFetch->name, new \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Scalar\String_($name))) : $scope);
            if ($reflection === null) {
                continue;
            }
            $reflections[] = $reflection;
        }
        return $reflections;
    }
    /**
     * @param \PhpParser\Node\Expr\PropertyFetch|\PhpParser\Node\Expr\StaticPropertyFetch $propertyFetch
     * @param \PHPStan\Analyser\Scope $scope
     * @return FoundPropertyReflection|null
     */
    public function findPropertyReflectionFromNode($propertyFetch, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\FoundPropertyReflection
    {
        if ($propertyFetch instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Expr\PropertyFetch) {
            if (!$propertyFetch->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier) {
                return null;
            }
            $propertyHolderType = $scope->getType($propertyFetch->var);
            return $this->findPropertyReflection($propertyHolderType, $propertyFetch->name->name, $scope);
        }
        if (!$propertyFetch->name instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Identifier) {
            return null;
        }
        if ($propertyFetch->class instanceof \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Name) {
            $propertyHolderType = $scope->resolveTypeByName($propertyFetch->class);
        } else {
            $propertyHolderType = $scope->getType($propertyFetch->class);
        }
        return $this->findPropertyReflection($propertyHolderType, $propertyFetch->name->name, $scope);
    }
    private function findPropertyReflection(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $propertyHolderType, string $propertyName, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : ?\TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\FoundPropertyReflection
    {
        if (!$propertyHolderType->hasProperty($propertyName)->yes()) {
            return null;
        }
        $originalProperty = $propertyHolderType->getProperty($propertyName, $scope);
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Properties\FoundPropertyReflection($originalProperty, $scope, $propertyName, $originalProperty->getReadableType(), $originalProperty->getWritableType());
    }
}
