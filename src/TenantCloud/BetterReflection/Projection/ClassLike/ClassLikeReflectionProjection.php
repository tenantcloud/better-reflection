<?php

namespace TenantCloud\BetterReflection\Projection\ClassLike;

use TenantCloud\BetterReflection\Reflection\ClassLikeReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;

interface ClassLikeReflectionProjection extends ClassLikeReflection
{
	public function resolvedTypeParameterMap(): TemplateTypeMap;
}
