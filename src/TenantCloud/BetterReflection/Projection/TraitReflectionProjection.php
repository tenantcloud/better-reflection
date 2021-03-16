<?php

namespace TenantCloud\BetterReflection\Projection;

use Ds\Sequence;
use JetBrains\PhpStorm\Immutable;
use TenantCloud\BetterReflection\Reflection\Attributes\AttributeSequence;
use TenantCloud\BetterReflection\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Reflection\PropertyReflection;
use TenantCloud\BetterReflection\Reflection\TraitReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\TypeParameterMapConverter;
use TenantCloud\Standard\Lazy\Lazy;
use function TenantCloud\Standard\Lazy\lazy;

#[Immutable]
final class TraitReflectionProjection implements TraitReflection
{
	private Lazy $methods;

	private Lazy $properties;

	private Lazy $uses;

	public function __construct(
		private TraitReflection $delegate,
		private TemplateTypeMap $resolvedTypeParameterMap,
	) {
		$this->methods = lazy(
			fn () => $this->delegate
				->methods()
				->map(fn (MethodReflection $method) => new MethodReflectionProjection($method, $resolvedTypeParameterMap))
		);
		$this->properties = lazy(
			fn () => $this->delegate
				->properties()
				->map(fn (PropertyReflection $property) => new PropertyReflectionProjection($property, $resolvedTypeParameterMap))
		);
		$this->uses = lazy(
			fn () => $this->delegate
				->uses()
				->map(fn (Type $type) => TemplateTypeHelper::resolveTemplateTypes(
					$type,
					$resolvedTypeParameterMap
				))
		);
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
		return $this->resolvedTypeParameterMap;
	}

	public function uses(): Sequence
	{
		return $this->uses->value();
	}

	public function properties(): Sequence
	{
		return $this->properties->value();
	}

	public function methods(): Sequence
	{
		return $this->methods->value();
	}

	public function isSubClassOf(string $className): bool
	{
		return $this->delegate->isSubClassOf($className);
	}

	public function isBuiltIn(): bool
	{
		return $this->delegate->isBuiltIn();
	}

	public function toType(): GenericObjectType
	{
		return new GenericObjectType(
			$this->qualifiedName(),
			TypeParameterMapConverter::fromMap(
				$this->resolvedTypeParameterMap,
				$this->delegate->typeParameters()->toArray(),
			)
		);
	}
}
