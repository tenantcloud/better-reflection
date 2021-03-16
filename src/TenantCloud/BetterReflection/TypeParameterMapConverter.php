<?php

namespace TenantCloud\BetterReflection;

use TenantCloud\BetterReflection\Reflection\TypeParameterReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ErrorType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;

class TypeParameterMapConverter
{
	/**
	 * @param Type[]                    $types
	 * @param TypeParameterReflection[] $typeParameters
	 */
	public static function toMap(array $types, iterable $typeParameters): TemplateTypeMap
	{
		$map = [];
		$i = 0;

		foreach ($typeParameters as $parameter) {
			$map[$parameter->name()] = $types[$i] ?? new ErrorType();
			$i++;
		}

		return new TemplateTypeMap($map);
	}

	public static function fromMap(TemplateTypeMap $map, array $typeParameters): array
	{
		$resolvedParameters = [];

		foreach ($typeParameters as $parameter) {
			/* @var TypeParameterReflection $parameter */
			$resolvedParameters[$parameter->name()] = $map->getType($parameter->name());
		}

		return $resolvedParameters;
	}
}
