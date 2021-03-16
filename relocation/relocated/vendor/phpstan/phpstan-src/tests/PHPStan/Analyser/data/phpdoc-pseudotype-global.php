<?php

namespace TenantCloud\BetterReflection\Relocated;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
function () {
    /** @var Number $number */
    $number = \TenantCloud\BetterReflection\Relocated\doFoo();
    /** @var Boolean $boolean */
    $boolean = \TenantCloud\BetterReflection\Relocated\doFoo();
    /** @var Numeric $numeric */
    $numeric = \TenantCloud\BetterReflection\Relocated\doFoo();
    /** @var Never $never */
    $never = \TenantCloud\BetterReflection\Relocated\doFoo();
    /** @var Resource $resource */
    $resource = \TenantCloud\BetterReflection\Relocated\doFoo();
    /** @var Double $double */
    $double = \TenantCloud\BetterReflection\Relocated\doFoo();
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('float|int', $number);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('float|int|(string&numeric)', $numeric);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('bool', $boolean);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('resource', $resource);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('*NEVER*', $never);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('float', $double);
};
