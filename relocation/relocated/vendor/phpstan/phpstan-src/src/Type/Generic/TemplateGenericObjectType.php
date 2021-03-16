<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
final class TemplateGenericObjectType extends \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType
{
    use UndecidedComparisonCompoundTypeTrait;
    /** @use TemplateTypeTrait<GenericObjectType> */
    use TemplateTypeTrait;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope $scope, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeStrategy $templateTypeStrategy, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance $templateTypeVariance, string $name, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType $bound)
    {
        parent::__construct($bound->getClassName(), $bound->getTypes());
        $this->scope = $scope;
        $this->strategy = $templateTypeStrategy;
        $this->variance = $templateTypeVariance;
        $this->name = $name;
        $this->bound = $bound;
    }
    public function traverse(callable $cb) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $newBound = $cb($this->getBound());
        if ($this->getBound() !== $newBound && $newBound instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType) {
            return new self($this->scope, $this->strategy, $this->variance, $this->name, $newBound);
        }
        return $this;
    }
    protected function recreate(string $className, array $types, ?\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $subtractedType) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType
    {
        return new self($this->scope, $this->strategy, $this->variance, $this->name, $this->getBound());
    }
}
