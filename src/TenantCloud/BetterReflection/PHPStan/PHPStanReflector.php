<?php

namespace TenantCloud\BetterReflection\PHPStan;

use TenantCloud\BetterReflection\PHPStan\Compatibility\BrokerBinder;
use TenantCloud\BetterReflection\Reflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Broker\Broker;
use TenantCloud\BetterReflection\Resolved\ResolvedAttributeClassReflection;
use TenantCloud\BetterReflection\Resolved\ResolvedClassReflection;
use TenantCloud\BetterReflection\Resolved\ResolvedInterfaceReflection;
use TenantCloud\BetterReflection\Resolved\ResolvedTraitReflection;

/**
 * Provides reflection through PHPStan and partly native reflection with additional caching.
 */
class PHPStanReflector implements Reflector
{
	public function __construct(
		private SourceResolvedMapper $mapper,
		private Broker $broker,
	) {
	}

	public function forClass(string $type): ResolvedClassReflection
	{
		return BrokerBinder::with($this->broker, function () use ($type) {
			$reflection = $this->broker->getClass($type);

			return new ResolvedClassReflection(
				className: $type,
				properties: $this->mapper->properties($reflection),
				methods: $this->mapper->methods($reflection),
				typeParameters: $this->mapper->typeParameters($reflection),
				extends: $this->mapper->parent($reflection),
				implements: $this->mapper->interfaces($reflection),
				uses: $this->mapper->uses($reflection),
			);
		});
	}

	public function forInterface(string $type): ResolvedInterfaceReflection
	{
		return BrokerBinder::with($this->broker, function () use ($type) {
			$reflection = $this->broker->getClass($type);

			return new ResolvedInterfaceReflection(
				className: $type,
				methods: $this->mapper->methods($reflection),
				typeParameters: $this->mapper->typeParameters($reflection),
				extends: $this->mapper->interfaces($reflection),
			);
		});
	}

	public function forTrait(string $type): ResolvedTraitReflection
	{
		return BrokerBinder::with($this->broker, function () use ($type) {
			$reflection = $this->broker->getClass($type);

			return new ResolvedTraitReflection(
				className: $type,
				properties: $this->mapper->properties($reflection),
				methods: $this->mapper->methods($reflection),
				typeParameters: $this->mapper->typeParameters($reflection),
				uses: $this->mapper->uses($reflection),
			);
		});
	}

	public function forAttributeClass(string $type): ResolvedAttributeClassReflection
	{
		return BrokerBinder::with($this->broker, function () use ($type) {
			$reflection = $this->broker->getClass($type);

			return new ResolvedAttributeClassReflection(
				className: $type,
				properties: $this->mapper->properties($reflection),
				methods: $this->mapper->methods($reflection),
				typeParameters: $this->mapper->typeParameters($reflection),
				extends: $this->mapper->parent($reflection),
				implements: $this->mapper->interfaces($reflection),
				uses: $this->mapper->uses($reflection),
			);
		});
	}
}
