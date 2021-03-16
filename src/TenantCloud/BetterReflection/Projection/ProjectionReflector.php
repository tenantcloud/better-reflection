<?php

namespace TenantCloud\BetterReflection\Projection;

use Attribute;
use InvalidArgumentException;
use ReflectionClass;
use TenantCloud\BetterReflection\Projection\ClassLike\AttributeClassClassLikeReflectionProjection;
use TenantCloud\BetterReflection\Projection\ClassLike\ClassClassLikeReflectionProjection;
use TenantCloud\BetterReflection\Projection\ClassLike\ClassLikeReflectionProjection;
use TenantCloud\BetterReflection\Projection\ClassLike\InterfaceClassLikeReflectionProjection;
use TenantCloud\BetterReflection\Projection\ClassLike\TraitClassLikeReflectionProjection;
use TenantCloud\BetterReflection\Reflector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\TypeWithClassName;
use TenantCloud\BetterReflection\TypeParameterMapConverter;

class ProjectionReflector implements Reflector
{
	public function __construct(
		private Reflector $delegate,
	) {
	}

	public function for(string | object $type, TemplateTypeMap $resolvedTemplateTypeMap = null): ClassLikeReflectionProjection
	{
		$className = $this->prepareObjectType($type)->getClassName();

		if (class_exists($className)) {
			$isAttribute = (new ReflectionClass($className))->getAttributes(Attribute::class);

			return $isAttribute ?
				new AttributeClassClassLikeReflectionProjection($this->forAttributeClass($type, $resolvedTemplateTypeMap)) :
				new ClassClassLikeReflectionProjection($this->forClass($type, $resolvedTemplateTypeMap));
		}

		if (interface_exists($className)) {
			return new InterfaceClassLikeReflectionProjection($this->forInterface($type, $resolvedTemplateTypeMap));
		}

		if (trait_exists($className)) {
			return new TraitClassLikeReflectionProjection($this->forTrait($type, $resolvedTemplateTypeMap));
		}

		throw new InvalidArgumentException();
	}

	public function forClass(string | object $type, TemplateTypeMap $resolvedTemplateTypeMap = null): ClassReflectionProjection
	{
		$type = $this->prepareObjectType($type);

		return new ClassReflectionProjection(
			$reflectionDelegate = $this->delegate->forClass($type->getClassName()),
			$resolvedTemplateTypeMap ?? TypeParameterMapConverter::toMap($type->getTypes(), $reflectionDelegate->typeParameters()),
		);
	}

	public function forInterface(string | object $type, TemplateTypeMap $resolvedTemplateTypeMap = null): InterfaceReflectionProjection
	{
		$type = $this->prepareObjectType($type);

		return new InterfaceReflectionProjection(
			$reflectionDelegate = $this->delegate->forInterface($type->getClassName()),
			$resolvedTemplateTypeMap ?? TypeParameterMapConverter::toMap($type->getTypes(), $reflectionDelegate->typeParameters()),
		);
	}

	public function forTrait(string | object $type, TemplateTypeMap $resolvedTemplateTypeMap = null): TraitReflectionProjection
	{
		$type = $this->prepareObjectType($type);

		return new TraitReflectionProjection(
			$reflectionDelegate = $this->delegate->forTrait($type->getClassName()),
			$resolvedTemplateTypeMap ?? TypeParameterMapConverter::toMap($type->getTypes(), $reflectionDelegate->typeParameters()),
		);
	}

	public function forAttributeClass(string | object $type, TemplateTypeMap $resolvedTemplateTypeMap = null): AttributeClassReflectionProjection
	{
		$type = $this->prepareObjectType($type);

		return new AttributeClassReflectionProjection(
			$reflectionDelegate = $this->delegate->forAttributeClass($type->getClassName()),
			$resolvedTemplateTypeMap ?? TypeParameterMapConverter::toMap($type->getTypes(), $reflectionDelegate->typeParameters()),
		);
	}

	private function prepareObjectType(string | object $className): GenericObjectType
	{
		if (is_string($className)) {
			$className = new GenericObjectType($className, []);
		}

		if (!$className instanceof TypeWithClassName) {
			$className = new GenericObjectType(get_class($className), []);
		}

		return $className;
	}
}
