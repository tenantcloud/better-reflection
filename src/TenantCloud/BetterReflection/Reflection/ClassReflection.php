<?php

namespace TenantCloud\BetterReflection\Reflection;

use Ds\Sequence;
use TenantCloud\BetterReflection\Reflection\Attributes\AttributeSequence;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;

/**
 * @template T Class being reflected
 */
interface ClassReflection extends QualifiableElement
{
	public function fileName(): string;

	public function attributes(): AttributeSequence;

	/**
	 * @return Sequence<TypeParameterReflection>
	 */
	public function typeParameters(): Sequence;

	public function extends(): ?Type;

	/**
	 * @return Sequence<Type>
	 */
	public function implements(): Sequence;

	/**
	 * @return Sequence<Type>
	 */
	public function uses(): Sequence;

	/**
	 * @return Sequence<PropertyReflection<T, mixed>>
	 */
	public function properties(): Sequence;

	/**
	 * @return Sequence<MethodReflection<T, mixed>>
	 */
	public function methods(): Sequence;

	public function isSubClassOf(string $className): bool;

	public function isAnonymous(): bool;

	public function isAbstract(): bool;

	public function isFinal(): bool;

	public function isBuiltIn(): bool;
}
