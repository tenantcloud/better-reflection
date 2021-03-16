<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4606;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
/**
 * @var Foo $this
 * @var array $assigned
 * @phpstan-var list<array{\stdClass, int}> $assigned
 */
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\Bug4606\Foo::class, $this);
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<int, array(stdClass, int)>', $assigned);
/**
 * @var array
 * @phpstan-var array{\stdClass, int}
 */
$foo = doFoo();
\TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(stdClass, int)', $foo);
