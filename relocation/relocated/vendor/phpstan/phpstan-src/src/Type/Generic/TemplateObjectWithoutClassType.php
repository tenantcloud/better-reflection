<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
class TemplateObjectWithoutClassType extends \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType
{
    use UndecidedComparisonCompoundTypeTrait;
    /** @use TemplateTypeTrait<ObjectWithoutClassType> */
    use TemplateTypeTrait;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope $scope, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeStrategy $templateTypeStrategy, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance $templateTypeVariance, string $name, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType $bound)
    {
        parent::__construct();
        $this->scope = $scope;
        $this->strategy = $templateTypeStrategy;
        $this->variance = $templateTypeVariance;
        $this->name = $name;
        $this->bound = $bound;
    }
    public function traverse(callable $cb) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $newBound = $cb($this->getBound());
        if ($this->getBound() !== $newBound && $newBound instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectWithoutClassType) {
            return new self($this->scope, $this->strategy, $this->variance, $this->name, $newBound);
        }
        return $this;
    }
}
