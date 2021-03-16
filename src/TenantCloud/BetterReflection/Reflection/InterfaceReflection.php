<?php

namespace TenantCloud\BetterReflection\Reflection;

use Ds\Sequence;
use TenantCloud\BetterReflection\Reflection\Attributes\AttributeSequence;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;

/**
 * @template T Interface being reflected
 */
interface InterfaceReflection extends QualifiableElement
{
	public function fileName(): string;

	public function attributes(): AttributeSequence;

	/**
	 * @return Sequence<TypeParameterReflection>
	 */
	public function typeParameters(): Sequence;

	/**
	 * @return Sequence<Type>
	 */
	public function extends(): Sequence;

	/**
	 * @return Sequence<MethodReflection<T, mixed>>
	 */
	public function methods(): Sequence;

	public function isSubClassOf(string $className): bool;

	public function isBuiltIn(): bool;
}
