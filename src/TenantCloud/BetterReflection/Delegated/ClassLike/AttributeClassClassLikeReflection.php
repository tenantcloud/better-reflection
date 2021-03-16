<?php

namespace TenantCloud\BetterReflection\Delegated\ClassLike;

use Ds\Sequence;
use TenantCloud\BetterReflection\Reflection\AttributeClassReflection;
use TenantCloud\BetterReflection\Reflection\Attributes\AttributeSequence;
use TenantCloud\BetterReflection\Reflection\ClassLikeReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;

class AttributeClassClassLikeReflection implements ClassLikeReflection
{
	public function __construct(
		private AttributeClassReflection $delegate,
	) {
	}

	public function fileName(): string
	{
		return $this->delegate->fileName();
	}

	public function qualifiedName(): string
	{
		return $this->delegate->qualifiedName();
	}

	public function attributes(): AttributeSequence
	{
		return $this->delegate->attributes();
	}

	public function typeParameters(): Sequence
	{
		return $this->delegate->typeParameters();
	}

	public function extends(): ?Type
	{
		return $this->delegate->extends();
	}

	public function implements(): Sequence
	{
		return $this->delegate->implements();
	}

	public function uses(): Sequence
	{
		return $this->delegate->uses();
	}

	public function properties(): Sequence
	{
		return $this->delegate->properties();
	}

	public function methods(): Sequence
	{
		return $this->delegate->methods();
	}

	public function isSubClassOf(string $className): bool
	{
		return $this->delegate->isSubClassOf($className);
	}

	public function isInterface(): bool
	{
		return false;
	}

	public function isTrait(): bool
	{
		return false;
	}

	public function isClass(): bool
	{
		return false;
	}

	public function isAttributeClass(): bool
	{
		return true;
	}

	public function isAnonymous(): bool
	{
		return $this->delegate->isAnonymous();
	}

	public function isAbstract(): bool
	{
		return $this->delegate->isAbstract();
	}

	public function isFinal(): bool
	{
		return $this->delegate->isFinal();
	}

	public function isBuiltIn(): bool
	{
		return $this->delegate->isBuiltIn();
	}
}
