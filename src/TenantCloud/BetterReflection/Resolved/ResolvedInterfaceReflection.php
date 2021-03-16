<?php

namespace TenantCloud\BetterReflection\Resolved;

use Ds\Sequence;
use Ds\Vector;
use ReflectionAttribute;
use ReflectionClass;
use TenantCloud\BetterReflection\Reflection\Attributes\AttributeSequence;
use TenantCloud\BetterReflection\Reflection\Attributes\DelegatedAttributeSequence;
use TenantCloud\BetterReflection\Reflection\InterfaceReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;

class ResolvedInterfaceReflection implements InterfaceReflection
{
	/**
	 * @param ResolvedMethodReflection[]        $methods
	 * @param ResolvedTypeParameterReflection[] $typeParameters
	 * @param Type[]                            $extends
	 */
	public function __construct(
		private string $className,
		private array $methods,
		private array $typeParameters,
		private array $extends,
	) {
	}

	public static function __set_state(array $data): static
	{
		return new self(
			className: $data['className'],
			methods: $data['methods'],
			typeParameters: $data['typeParameters'],
			extends: $data['extends'],
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

	public function extends(): Sequence
	{
		return new Vector($this->extends);
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
