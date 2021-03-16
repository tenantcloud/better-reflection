<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\Bug3425;

new \RecursiveIteratorIterator((function () {
    (yield 22);
})());
