<?php

namespace TenantCloud\BetterReflection\Relocated\PhpdocPseudoTypesNamespace;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Number
{
}
class Numeric
{
}
class Boolean
{
}
class Resource
{
}
class Never
{
}
class Double
{
}
function () {
    /** @var Number $number */
    $number = doFoo();
    /** @var Boolean $boolean */
    $boolean = doFoo();
    /** @var Numeric $numeric */
    $numeric = doFoo();
    /** @var Never $never */
    $never = doFoo();
    /** @var Resource $resource */
    $resource = doFoo();
    /** @var Double $double */
    $double = doFoo();
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PhpdocPseudoTypesNamespace\\Number', $number);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PhpdocPseudoTypesNamespace\\Numeric', $numeric);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PhpdocPseudoTypesNamespace\\Boolean', $boolean);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PhpdocPseudoTypesNamespace\\Resource', $resource);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PhpdocPseudoTypesNamespace\\Never', $never);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\PhpdocPseudoTypesNamespace\\Double', $double);
};
