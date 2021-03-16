<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic;

use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Traits\UndecidedComparisonCompoundTypeTrait;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
final class TemplateIntegerType extends \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType
{
    /** @use TemplateTypeTrait<IntegerType> */
    use TemplateTypeTrait;
    use UndecidedComparisonCompoundTypeTrait;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope $scope, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeStrategy $templateTypeStrategy, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance $templateTypeVariance, string $name, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType $bound)
    {
        $this->scope = $scope;
        $this->strategy = $templateTypeStrategy;
        $this->variance = $templateTypeVariance;
        $this->name = $name;
        $this->bound = $bound;
    }
    public function traverse(callable $cb) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $newBound = $cb($this->getBound());
        if ($this->getBound() !== $newBound && $newBound instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType) {
            return new self($this->scope, $this->strategy, $this->variance, $this->name, $newBound);
        }
        return $this;
    }
    protected function shouldGeneralizeInferredType() : bool
    {
        return \false;
    }
}
