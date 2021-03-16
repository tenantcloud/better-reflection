<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
final class TemplateMixedType extends \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType implements \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateType
{
    /** @use TemplateTypeTrait<MixedType> */
    use TemplateTypeTrait;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope $scope, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeStrategy $templateTypeStrategy, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance $templateTypeVariance, string $name, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType $bound)
    {
        parent::__construct(\true);
        $this->scope = $scope;
        $this->strategy = $templateTypeStrategy;
        $this->variance = $templateTypeVariance;
        $this->name = $name;
        $this->bound = $bound;
    }
    public function isSuperTypeOfMixed(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType $type) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        return $this->isSuperTypeOf($type);
    }
    public function isAcceptedBy(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $acceptingType, bool $strictTypes) : \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic
    {
        $isSuperType = $this->isSuperTypeOf($acceptingType);
        if ($isSuperType->no()) {
            return $isSuperType;
        }
        return \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes();
    }
    public function traverse(callable $cb) : \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type
    {
        $newBound = $cb($this->getBound());
        if ($this->getBound() !== $newBound && $newBound instanceof \TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType) {
            return new self($this->scope, $this->strategy, $this->variance, $this->name, $newBound);
        }
        return $this;
    }
}
