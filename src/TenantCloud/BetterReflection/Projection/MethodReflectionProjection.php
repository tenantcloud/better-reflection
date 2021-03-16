<?php

namespace TenantCloud\BetterReflection\Projection;

use Ds\Sequence;
use TenantCloud\BetterReflection\Reflection\Attributes\AttributeSequence;
use TenantCloud\BetterReflection\Reflection\FunctionParameterReflection;
use TenantCloud\BetterReflection\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\Standard\Lazy\Lazy;
use function TenantCloud\Standard\Lazy\lazy;

class MethodReflectionProjection implements MethodReflection
{
	private Lazy $parameters;

	private Lazy $returnType;

	public function __construct(
		private MethodReflection $delegate,
		private TemplateTypeMap $resolvedTypeParameterMap,
	) {
		$this->parameters = lazy(
			fn () => $this->delegate
				->parameters()
				->map(fn (FunctionParameterReflection $parameter) => new FunctionParameterReflectionProjection($parameter, $resolvedTypeParameterMap))
		);
		$this->returnType = lazy(
			fn () => TemplateTypeHelper::resolveTemplateTypes(
				$this->delegate->returnType(),
				$resolvedTypeParameterMap
			)
		);
	}

	public function name(): string
	{
		return $this->delegate->name();
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

	public function parameters(): Sequence
	{
		return $this->parameters->value();
	}

	public function returnType(): Type
	{
		return $this->returnType->value();
	}

	public function invoke(object $receiver, mixed ...$args): mixed
	{
		$this->delegate->invoke($receiver, ...$args);
	}
}
