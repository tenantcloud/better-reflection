<?php

namespace TenantCloud\BetterReflection\PHPStan;

use ReflectionMethod;
use ReflectionProperty;
use TenantCloud\BetterReflection\ObjectTypeFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\TemplateTag;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParameterReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ParametersAcceptorSelector;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpClassReflectionExtension;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\Resolved\ResolvedFunctionParameterReflection;
use TenantCloud\BetterReflection\Resolved\ResolvedMethodReflection;
use TenantCloud\BetterReflection\Resolved\ResolvedPropertyReflection;
use TenantCloud\BetterReflection\Resolved\ResolvedTypeParameterReflection;

class SourceResolvedMapper
{
	public function __construct(
		private PhpClassReflectionExtension $phpClassReflectionExtension,
	) {
	}

	public function typeParameters(ClassReflection $reflection): array
	{
		return array_map(
			fn (TemplateTag $typeParameterDelegate) => new ResolvedTypeParameterReflection(
				name: $typeParameterDelegate->getName(),
				upperBound: $typeParameterDelegate->getBound(),
				variance: $typeParameterDelegate->getVariance(),
			),
			$reflection->getTemplateTags(),
		);
	}

	public function properties(ClassReflection $reflection): array
	{
		$nativeProperties = $reflection
			->getNativeReflection()
			->getProperties();

		return array_map(function (ReflectionProperty $nativeProperty) use ($reflection) {
			$extensionProperty = $this->phpClassReflectionExtension->getNativeProperty($reflection, $nativeProperty->getName());

			return new ResolvedPropertyReflection(
				className: $reflection->getName(),
				name: $nativeProperty->getName(),
				type: $extensionProperty->getReadableType(),
			);
		}, $nativeProperties);
	}

	public function methods(ClassReflection $reflection): array
	{
		$nativeMethods = $reflection
			->getNativeReflection()
			->getMethods();

		return array_map(function (ReflectionMethod $nativeMethod) use ($reflection) {
			$extensionMethod = $this->phpClassReflectionExtension->getNativeMethod($reflection, $nativeMethod->getName());
			$variant = ParametersAcceptorSelector::selectSingle($extensionMethod->getVariants());

			return new ResolvedMethodReflection(
				className: $reflection->getName(),
				name: $nativeMethod->getName(),
				typeParameters: array_map(
					fn (Type $type, string $name) => new ResolvedTypeParameterReflection(
						name: $name,
						upperBound: $type,
						variance: TemplateTypeVariance::createInvariant(),
					),
					$variant->getTemplateTypeMap()->getTypes(),
					array_keys($variant->getTemplateTypeMap()->getTypes())
				),
				parameters: array_map(
					fn (ParameterReflection $parameterDelegate) => new ResolvedFunctionParameterReflection(
						$reflection->getName(),
						$nativeMethod->getName(),
						$parameterDelegate->getName(),
						$parameterDelegate->getType(),
					),
					$variant->getParameters()
				),
				returnType: $variant->getReturnType(),
			);
		}, $nativeMethods);
	}

	public function parent(ClassReflection $reflection): ?Type
	{
		$parentReflection = $reflection->getParentClass();

		if (!$parentReflection) {
			return null;
		}

		return ObjectTypeFactory::fromReflection($parentReflection);
	}

	public function interfaces(ClassReflection $reflection): array
	{
		return array_map(
			fn (ClassReflection $interfaceReflection) => ObjectTypeFactory::fromReflection($interfaceReflection),
			$reflection->getInterfaces()
		);
	}

	public function uses(ClassReflection $reflection): array
	{
		return array_map(
			fn (ClassReflection $traitReflection) => ObjectTypeFactory::fromReflection($traitReflection),
			$reflection->getTraits()
		);
	}
}
