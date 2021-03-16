<?php

namespace TenantCloud\BetterReflection\Projection;

use TenantCloud\BetterReflection\Reflection\Attributes\AttributeSequence;
use TenantCloud\BetterReflection\Reflection\FunctionParameterReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\Standard\Lazy\Lazy;
use function TenantCloud\Standard\Lazy\lazy;

class FunctionParameterReflectionProjection implements FunctionParameterReflection
{
	private Lazy $type;

	public function __construct(
		private FunctionParameterReflection $delegate,
		private TemplateTypeMap $resolvedTypeParameterMap,
	) {
		$this->type = lazy(
			fn () => TemplateTypeHelper::resolveTemplateTypes(
				$this->delegate->type(),
				$resolvedTypeParameterMap
			)
		);
	}

	public function name(): string
	{
		return $this->delegate->name();
	}

	public function type(): Type
	{
		return $this->type->value();
	}

	public function attributes(): AttributeSequence
	{
		return $this->delegate->attributes();
	}
}
