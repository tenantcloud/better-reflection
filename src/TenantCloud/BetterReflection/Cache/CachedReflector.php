<?php

namespace TenantCloud\BetterReflection\Cache;

use ReflectionClass;
use TenantCloud\BetterReflection\Reflection\AttributeClassReflection;
use TenantCloud\BetterReflection\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Reflection\InterfaceReflection;
use TenantCloud\BetterReflection\Reflection\TraitReflection;
use TenantCloud\BetterReflection\Reflector;
use TenantCloud\Standard\Lazy\Lazy;

class CachedReflector implements Reflector
{
	public function __construct(
		private ReflectionCacheKeyMaster $reflectionCacheKeyMaster,
		private Cache $cache,
		private Lazy $delegate,
	) {
	}

	public function forClass(string $type): ClassReflection
	{
		return $this->cache($type, fn () => $this->delegate->value()->forClass($type));
	}

	public function forInterface(string $type): InterfaceReflection
	{
		return $this->cache($type, fn () => $this->delegate->value()->forInterface($type));
	}

	public function forTrait(string $type): TraitReflection
	{
		return $this->cache($type, fn () => $this->delegate->value()->forTrait($type));
	}

	public function forAttributeClass(string $type): AttributeClassReflection
	{
		return $this->cache($type, fn () => $this->delegate->value()->forAttributeClass($type));
	}

	private function cache(string $className, callable $resolve)
	{
		// This should be compatible with everything class-like
		$nativeReflection = new ReflectionClass($className);

		return $this->cache->remember(
			$this->reflectionCacheKeyMaster->key($nativeReflection),
			$this->reflectionCacheKeyMaster->variableKey($nativeReflection),
			$resolve,
		);
	}
}
