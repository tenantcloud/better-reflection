<?php

namespace TenantCloud\BetterReflection\Delegated\ClassLike;

use Ds\Sequence;
use Ds\Vector;
use TenantCloud\BetterReflection\Reflection\Attributes\AttributeSequence;
use TenantCloud\BetterReflection\Reflection\ClassLikeReflection;
use TenantCloud\BetterReflection\Reflection\InterfaceReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;

class InterfaceClassLikeReflection implements ClassLikeReflection
{
	public function __construct(
		private InterfaceReflection $delegate,
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
		return null;
	}

	public function implements(): Sequence
	{
		return $this->delegate->extends();
	}

	public function uses(): Sequence
	{
		return new Vector();
	}

	public function properties(): Sequence
	{
		return new Vector();
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
		return true;
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
		return false;
	}

	public function isAnonymous(): bool
	{
		return false;
	}

	public function isAbstract(): bool
	{
		return true;
	}

	public function isFinal(): bool
	{
		return false;
	}

	public function isBuiltIn(): bool
	{
		return $this->delegate->isBuiltIn();
	}
}
