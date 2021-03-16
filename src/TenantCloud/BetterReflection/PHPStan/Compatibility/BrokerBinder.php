<?php

namespace TenantCloud\BetterReflection\PHPStan\Compatibility;

use ReflectionClass;
use TenantCloud\BetterReflection\Projection\ProjectionReflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\DirectDynamicReturnTypeExtensionRegistryProvider;
use TenantCloud\BetterReflection\Relocated\PHPStan\DependencyInjection\Type\DirectOperatorTypeSpecifyingExtensionRegistryProvider;
use TenantCloud\Standard\StaticConstructor\HasStaticConstructor;

class BrokerBinder implements HasStaticConstructor
{
	private static bool $isBound = false;

	private static ReflectionClass $brokerReflection;

	private function __construct()
	{
	}

	public static function __constructStatic(): void
	{
		self::$brokerReflection = new ReflectionClass(Broker::class);
	}

	public static function with(Broker $broker, callable $execute): mixed
	{
		// getInstance() might throw an exception, which isn't what we want.
		$previous = self::$brokerReflection->getStaticPropertyValue('instance');

		Broker::registerInstance($broker);

		$return = $execute();

		self::$brokerReflection->setStaticPropertyValue('instance', $previous);

		return $return;
	}

	public static function bind(ProjectionReflector $reflector): void
	{
		Broker::registerInstance(
			$broker = new Broker(
				reflectionProvider: new TenantCloudReflectionProvider($reflector),
				dynamicReturnTypeExtensionRegistryProvider: $dynamicReturnTypeExtensionRegistryProvider = new DirectDynamicReturnTypeExtensionRegistryProvider([], [], []),
				operatorTypeSpecifyingExtensionRegistryProvider: $operatorTypeSpecifyingExtensionRegistryProvider = new DirectOperatorTypeSpecifyingExtensionRegistryProvider([]),
				universalObjectCratesClasses: [],
			)
		);

		$dynamicReturnTypeExtensionRegistryProvider->setBroker($broker);
		$operatorTypeSpecifyingExtensionRegistryProvider->setBroker($broker);

		static::$isBound = true;
	}
}
