<?php

namespace TenantCloud\BetterReflection\Resolved;

use Ds\Sequence;
use Ds\Vector;
use ReflectionAttribute;
use ReflectionClass;
use TenantCloud\BetterReflection\Reflection\Attributes\AttributeSequence;
use TenantCloud\BetterReflection\Reflection\Attributes\DelegatedAttributeSequence;
use TenantCloud\BetterReflection\Reflection\TraitReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;

class ResolvedTraitReflection implements TraitReflection
{
	/**
	 * @param ResolvedPropertyReflection[]      $properties
	 * @param ResolvedMethodReflection[]        $methods
	 * @param ResolvedTypeParameterReflection[] $typeParameters
	 * @param Type[]                            $uses
	 */
	public function __construct(
		private string $className,
		private array $properties,
		private array $methods,
		private array $typeParameters,
		private array $uses,
	) {
	}

	public static function __set_state(array $data): static
	{
		return new self(
			className: $data['className'],
			properties: $data['properties'],
			methods: $data['methods'],
			typeParameters: $data['typeParameters'],
			uses: $data['uses'],
		);
	}

	public function fileName(): string
	{
		return $this->nativeReflection()->getFileName();
	}

	public function typeParameters(): Sequence
	{
		return new Vector($this->typeParameters);
	}

	public function uses(): Sequence
	{
		return new Vector($this->uses);
	}

	public function properties(): Sequence
	{
		return new Vector($this->properties);
	}

	public function methods(): Sequence
	{
		return new Vector($this->methods);
	}

	public function attributes(): AttributeSequence
	{
		return (new DelegatedAttributeSequence(new Vector($this->nativeReflection()->getAttributes())))
			->map(function (ReflectionAttribute $nativeAttribute) {
				// Why, PHP? Why the hell wouldn't you JUST give a list of instantiated attributes like other languages? ...
				return $nativeAttribute->newInstance();
			});
	}

	public function qualifiedName(): string
	{
		return $this->className;
	}

	public function isSubClassOf(string $className): bool
	{
		return $this->nativeReflection()->isSubclassOf($className);
	}

	public function isBuiltIn(): bool
	{
		return !$this->nativeReflection()->isUserDefined();
	}

	private function nativeReflection(): ReflectionClass
	{
		return new ReflectionClass($this->className);
	}
}
