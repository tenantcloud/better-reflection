<?php

namespace TenantCloud\BetterReflection\Projection;

use Ds\Sequence;
use JetBrains\PhpStorm\Immutable;
use TenantCloud\BetterReflection\Reflection\Attributes\AttributeSequence;
use TenantCloud\BetterReflection\Reflection\InterfaceReflection;
use TenantCloud\BetterReflection\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\TypeParameterMapConverter;
use TenantCloud\Standard\Lazy\Lazy;
use function TenantCloud\Standard\Lazy\lazy;

#[Immutable]
final class InterfaceReflectionProjection implements InterfaceReflection
{
	private Lazy $methods;

	private Lazy $extends;

	public function __construct(
		private InterfaceReflection $delegate,
		private TemplateTypeMap $resolvedTypeParameterMap,
	) {
		$this->methods = lazy(
			fn () => $this->delegate
				->methods()
				->map(fn (MethodReflection $method) => new MethodReflectionProjection($method, $resolvedTypeParameterMap))
		);
		$this->extends = lazy(
			fn () => $this->delegate
				->extends()
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

	public function extends(): Sequence
	{
		return $this->extends->value();
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
