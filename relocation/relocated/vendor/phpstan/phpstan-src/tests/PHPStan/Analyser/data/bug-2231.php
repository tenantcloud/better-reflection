<?php

namespace TenantCloud\BetterReflection\Relocated\Bug2231;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class Foo
{
    public function doFoo(?\TenantCloud\BetterReflection\Relocated\Bug2231\Foo $x) : void
    {
        if ($x !== null && !$x instanceof static) {
            throw new \TypeError('custom error');
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('static(Bug2231\\Foo)|null', $x);
    }
    public function doBar(?\TenantCloud\BetterReflection\Relocated\Bug2231\Foo $x) : void
    {
        if ($x !== null && !$x instanceof self) {
            throw new \TypeError('custom error');
        }
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('Bug2231\\Foo|null', $x);
    }
    public function doBaz($x) : void
    {
        if ($x instanceof self) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TenantCloud\\BetterReflection\\Relocated\\Bug2231\\Foo', $x);
        }
        if ($x instanceof static) {
            \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('static(Bug2231\\Foo)', $x);
        }
    }
}
