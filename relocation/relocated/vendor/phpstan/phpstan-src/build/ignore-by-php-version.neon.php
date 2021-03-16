<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated;

use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\NeonAdapter;
$adapter = new \TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\NeonAdapter();
$config = [];
if (\PHP_VERSION_ID >= 80000) {
    $config = \array_merge_recursive($config, $adapter->load(__DIR__ . '/baseline-8.0.neon'));
}
if (\PHP_VERSION_ID >= 70400) {
    $config = \array_merge_recursive($config, $adapter->load(__DIR__ . '/ignore-gte-php7.4-errors.neon'));
}
return $config;
