<?php

namespace TenantCloud\BetterReflection\Projection;

use TenantCloud\BetterReflection\Reflection\Attributes\AttributeSequence;
use TenantCloud\BetterReflection\Reflection\PropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeHelper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\Standard\Lazy\Lazy;
use function TenantCloud\Standard\Lazy\lazy;

class PropertyReflectionProjection implements PropertyReflection
{
	private Lazy $type;

	public function __construct(
		private PropertyReflection $delegate,
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

	public function get(object $receiver)
	{
		return $this->delegate->get($receiver);
	}

	public function set(object $receiver, mixed $value): void
	{
		$this->delegate->set($receiver, $value);
	}
}
