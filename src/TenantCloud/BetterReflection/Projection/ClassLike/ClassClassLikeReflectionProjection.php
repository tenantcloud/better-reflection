<?php

namespace TenantCloud\BetterReflection\Projection\ClassLike;

use Ds\Sequence;
use TenantCloud\BetterReflection\Delegated\ClassLike\ClassClassLikeReflection;
use TenantCloud\BetterReflection\Projection\ClassReflectionProjection;
use TenantCloud\BetterReflection\Reflection\Attributes\AttributeSequence;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;

class ClassClassLikeReflectionProjection implements ClassLikeReflectionProjection
{
	private ClassClassLikeReflection $delegate;

	public function __construct(
		private ClassReflectionProjection $classDelegate,
	) {
		$this->delegate = new ClassClassLikeReflection($classDelegate);
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

	public function resolvedTypeParameterMap(): TemplateTypeMap
	{
		return $this->classDelegate->resolvedTypeParameterMap();
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
		return $this->delegate->isInterface();
	}

	public function isTrait(): bool
	{
		return $this->delegate->isTrait();
	}

	public function isClass(): bool
	{
		return $this->delegate->isClass();
	}

	public function isAttributeClass(): bool
	{
		return $this->delegate->isAttributeClass();
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
