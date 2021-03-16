<?php

namespace TenantCloud\BetterReflection\Relocated;

use TenantCloud\BetterReflection\Relocated\Foo\Number;
use TenantCloud\BetterReflection\Relocated\Foo\Numeric;
use TenantCloud\BetterReflection\Relocated\Foo\Boolean;
use TenantCloud\BetterReflection\Relocated\Foo\Resource;
use TenantCloud\BetterReflection\Relocated\Foo\Never;
use TenantCloud\BetterReflection\Relocated\Foo\Double;
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
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Foo\\Number', $number);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Foo\\Numeric', $numeric);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Foo\\Boolean', $boolean);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Foo\\Resource', $resource);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Foo\\Never', $never);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Foo\\Double', $double);
};
