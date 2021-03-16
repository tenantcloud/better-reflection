<?php

namespace TenantCloud\BetterReflection;

use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;

class ObjectTypeFactory
{
	public static function fromReflection(ClassReflection $reflection): ObjectType
	{
		if (!$reflection->isGeneric()) {
			return new ObjectType($reflection->getName());
		}

		return new GenericObjectType(
			$reflection->getName(),
			$reflection->typeMapToList($reflection->getActiveTemplateTypeMap())
		);
	}
}
