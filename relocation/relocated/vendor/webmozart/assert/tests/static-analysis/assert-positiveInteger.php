<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @psalm-return positive-int
 */
function positiveInteger($value) : int
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::positiveInteger($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param 0|1|2 $value
 *
 * @psalm-return 1|2
 */
function positiveIntegerFiltersOutZero($value) : int
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::positiveInteger($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @psalm-return positive-int|null
 */
function nullOrPositiveInteger($value) : ?int
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrPositiveInteger($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return iterable<positive-int>
 */
function allPositiveInteger($value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allPositiveInteger($value);
    return $value;
}
