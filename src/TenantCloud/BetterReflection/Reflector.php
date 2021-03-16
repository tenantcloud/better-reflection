<?php

namespace TenantCloud\BetterReflection;

use TenantCloud\BetterReflection\Reflection\AttributeClassReflection;
use TenantCloud\BetterReflection\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Reflection\InterfaceReflection;
use TenantCloud\BetterReflection\Reflection\TraitReflection;

interface Reflector
{
	/**
	 * @template T
	 *
	 * @param class-string<T> $type
	 *
	 * @return ClassReflection<T>
	 */
	public function forClass(string $type): ClassReflection;

	/**
	 * @template T
	 *
	 * @param class-string<T> $type
	 *
	 * @return InterfaceReflection<T>
	 */
	public function forInterface(string $type): InterfaceReflection;

	/**
	 * @template T
	 *
	 * @param class-string<T> $type
	 *
	 * @return TraitReflection<T>
	 */
	public function forTrait(string $type): TraitReflection;

	/**
	 * @template T
	 *
	 * @param class-string<T> $type
	 *
	 * @return AttributeClassReflection<T>
	 */
	public function forAttributeClass(string $type): AttributeClassReflection;
}
