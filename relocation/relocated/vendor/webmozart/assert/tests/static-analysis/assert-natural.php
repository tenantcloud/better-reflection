<?php

namespace TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Tests\StaticAnalysis;

use TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert;
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @psalm-return positive-int|0
 */
function natural($value) : int
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::natural($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @psalm-return positive-int|0|null
 */
function nullOrNatural($value) : ?int
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::nullOrNatural($value);
    return $value;
}
/**
 * @psalm-pure
 *
 * @param mixed $value
 *
 * @return iterable<positive-int|0>
 *
 * @psalm-suppress MixedInferredReturnType https://github.com/vimeo/psalm/issues/5052
 * @psalm-suppress MixedReturnStatement https://github.com/vimeo/psalm/issues/5052
 */
function allNatural($value) : iterable
{
    \TenantCloud\BetterReflection\Relocated\Webmozart\Assert\Assert::allNatural($value);
    return $value;
}
