<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic;

use TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel;
use TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase;
class TemplateTypeVarianceTest extends \TenantCloud\BetterReflection\Relocated\PHPUnit\Framework\TestCase
{
    public function dataIsValidVariance() : iterable
    {
        foreach ([\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createInvariant(), \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance::createCovariant()] as $variance) {
            (yield [$variance, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
            (yield [$variance, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
            (yield [$variance, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
            (yield [$variance, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
            (yield [$variance, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
            (yield [$variance, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
            (yield [$variance, new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\UnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()]), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\BenevolentUnionType([new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType()]), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes(), \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic::createYes()]);
        }
    }
    /**
     * @dataProvider dataIsValidVariance
     */
    public function testIsValidVariance(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance $variance, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $a, \TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type $b, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expected, \TenantCloud\BetterReflection\Relocated\PHPStan\TrinaryLogic $expectedInversed) : void
    {
        $this->assertSame($expected->describe(), $variance->isValidVariance($a, $b)->describe(), \sprintf('%s->isValidVariance(%s, %s)', $variance->describe(), $a->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $b->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
        $this->assertSame($expectedInversed->describe(), $variance->isValidVariance($b, $a)->describe(), \sprintf('%s->isValidVariance(%s, %s)', $variance->describe(), $b->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise()), $a->describe(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\VerbosityLevel::precise())));
    }
}
