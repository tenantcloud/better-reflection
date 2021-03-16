<?php

namespace TenantCloud\BetterReflection\PHPStan\Compatibility;

use ReflectionClass;
use TenantCloud\BetterReflection\Projection\ClassLike\ClassLikeReflectionProjection;
use TenantCloud\BetterReflection\Projection\ProjectionReflector;
use TenantCloud\BetterReflection\Reflection\TypeParameterReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\ResolvedPhpDocBlock;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\TemplateTag;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassMemberAccessAnswerer;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ClassReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\ConstantReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\MethodReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\PhpPropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PropertyReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeFactory;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
use TenantCloud\BetterReflection\TypeParameterMapConverter;
use TenantCloud\Standard\Lazy\Lazy;
use function TenantCloud\Standard\Lazy\lazy;

class TenantCloudClassReflection extends ClassReflection
{
	private Lazy $nativeReflection;

	private Lazy $ancestorsLazy;

	/**
	 * @noinspection MagicMethodsValidityInspection
	 * @noinspection PhpMissingParentConstructorInspection
	 */
	public function __construct(
		private ClassLikeReflectionProjection $delegate,
		private ProjectionReflector $reflector,
		private TenantCloudReflectionProvider $reflectionProvider,
	) {
		$this->nativeReflection = lazy(fn () => new ReflectionClass($delegate->qualifiedName()));
		$this->ancestorsLazy = lazy(function () {
			$ancestors = [$this->getName() => $this];

			$addToAncestors = static function (string $name, ClassReflection $classReflection) use (&$ancestors): void {
				if (array_key_exists($name, $ancestors)) {
					return;
				}
				$ancestors[$name] = $classReflection;
			};

			foreach ($this->getInterfaces() as $interface) {
				$addToAncestors($interface->getName(), $interface);

				foreach ($interface->getAncestors() as $name => $ancestor) {
					$addToAncestors($name, $ancestor);
				}
			}

			foreach ($this->getTraits() as $trait) {
				$addToAncestors($trait->getName(), $trait);

				foreach ($trait->getAncestors() as $name => $ancestor) {
					$addToAncestors($name, $ancestor);
				}
			}

			$parent = $this->getParentClass();

			if ($parent !== false) {
				$addToAncestors($parent->getName(), $parent);

				foreach ($parent->getAncestors() as $name => $ancestor) {
					$addToAncestors($name, $ancestor);
				}
			}

			return $ancestors;
		});
	}

	public function getFileName(): bool | string
	{
		return $this->delegate->fileName();
	}

	public function getFileNameWithPhpDocs(): ?string
	{
		return $this->delegate->fileName();
	}

	/**
	 * @return class-string
	 */
	public function getName(): string
	{
		return $this->delegate->qualifiedName();
	}

	public function getDisplayName(bool $withTemplateTypes = true): string
	{
		throw new ShouldNotHappenException();
	}

	public function getClassHierarchyDistances(): array
	{
		throw new ShouldNotHappenException();
	}

	public function getCacheKey(): string
	{
		throw new ShouldNotHappenException();
	}

	public function getNativeReflection(): ReflectionClass
	{
		return $this->nativeReflection->value();
	}

	/**
	 * @return \PHPStan\Reflection\ClassReflection[]
	 */
	public function getParents(): array
	{
		$parents = [];
		$parent = $this->getParentClass();

		while ($parent !== false) {
			$parents[] = $parent;
			$parent = $parent->getParentClass();
		}

		return $parents;
	}

	/**
	 * @return false|\PHPStan\Reflection\ClassReflection
	 */
	public function getParentClass()
	{
		if (!$this->delegate->extends()) {
			return false;
		}

		return new self(
			$this->reflector->for($this->delegate->extends()),
			$this->reflector,
			$this->reflectionProvider,
		);
	}

	/**
	 * @return \PHPStan\Reflection\ClassReflection[]
	 */
	public function getInterfaces(): array
	{
		return $this->delegate
			->implements()
			->map(fn (Type $type) => new self(
				$this->reflector->for($type),
				$this->reflector,
				$this->reflectionProvider,
			))
			->toArray();
	}

	/**
	 * @return \PHPStan\Reflection\ClassReflection[]
	 */
	public function getTraits(): array
	{
		return $this->delegate
			->uses()
			->map(fn (Type $type) => new self(
				$this->reflector->for($type),
				$this->reflector,
				$this->reflectionProvider,
			))
			->toArray();
	}

	/**
	 * @return string[]
	 */
	public function getParentClassesNames(): array
	{
		$parentNames = [];
		$currentClassReflection = $this;

		while ($currentClassReflection->getParentClass() !== false) {
			$parentNames[] = $currentClassReflection->getParentClass()->getName();
			$currentClassReflection = $currentClassReflection->getParentClass();
		}

		return $parentNames;
	}

	public function getAncestors(): array
	{
		return $this->ancestorsLazy->value();
	}

	public function getAncestorWithClassName(string $className): ?self
	{
		return $this->getAncestors()[$className] ?? null;
	}

	public function isSubclassOf(string $className): bool
	{
		return $this->delegate->isSubClassOf($className);
	}

	public function implementsInterface(string $className): bool
	{
		return $this->delegate->isSubClassOf($className);
	}

	public function hasTraitUse(string $traitName): bool
	{
		return $this->delegate->isSubClassOf($traitName);
	}

	public function isInterface(): bool
	{
		return $this->delegate->isInterface();
	}

	public function isTrait(): bool
	{
		return $this->delegate->isTrait();
	}

	public function isClass(): bool
	{
		return $this->delegate->isClass();
	}

	public function isAttributeClass(): bool
	{
		return $this->delegate->isAttributeClass();
	}

	public function getAttributeClassFlags(): int
	{
		return $this->delegate->attributeClassFlags();
	}

	public function isAnonymous(): bool
	{
		return $this->delegate->isAnonymous();
	}

	public function isAbstract(): bool
	{
		return $this->delegate->isAbstract();
	}

	public function isInternal(): bool
	{
		return false;
	}

	public function isFinal(): bool
	{
		return $this->delegate->isFinal();
	}

	public function isFinalByKeyword(): bool
	{
		return $this->delegate->isFinal();
	}

	public function isGeneric(): bool
	{
		return !$this->delegate->typeParameters()->isEmpty();
	}

	public function isDeprecated(): bool
	{
		return false;
	}

	public function getDeprecatedDescription(): ?string
	{
		return null;
	}

	public function isBuiltin(): bool
	{
		return $this->delegate->isBuiltIn();
	}

	public function getTemplateTypeMap(): TemplateTypeMap
	{
		$scope = TemplateTypeScope::createWithClass($this->delegate->qualifiedName());
		$map = [];

		foreach ($this->delegate->typeParameters() as $parameter) {
			$map[$parameter->name()] = TemplateTypeFactory::create(
				$scope,
				$parameter->name(),
				$parameter->upperBound(),
				$parameter->variance(),
			);
		}

		return new TemplateTypeMap($map);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getActiveTemplateTypeMap(): TemplateTypeMap
	{
		return $this->delegate->resolvedTypeParameterMap();
	}

	/**
	 * {@inheritDoc}
	 */
	public function withTypes(array $types): self
	{
		$delegate = $this->reflector->for(
			$this->delegate->qualifiedName(),
			$this->typeMapFromList($types),
		);

		return new self(
			$delegate,
			$this->reflector,
			$this->reflectionProvider
		);
	}

	/**
	 * {@inheritDoc}
	 */
	public function typeMapToList(TemplateTypeMap $typeMap): array
	{
		return $this->delegate
			->typeParameters()
			->map(
				fn (TypeParameterReflection $typeParameter) => $typeMap->getType($typeParameter->name()) ?? $typeParameter->upperBound(),
			)
			->toArray();
	}

	/**
	 * {@inheritDoc}
	 */
	public function typeMapFromList(array $types): TemplateTypeMap
	{
		return TypeParameterMapConverter::toMap($types, $this->delegate->typeParameters());
	}

	/**
	 * {@inheritDoc}
	 */
	public function getTemplateTags(): array
	{
		$tags = [];

		foreach ($this->delegate->typeParameters() as $parameter) {
			/* @var TypeParameterReflection $parameter */
			$tags[$parameter->name()] = new TemplateTag(
				$parameter->name(),
				$parameter->upperBound(),
				$parameter->variance(),
			);
		}

		return $tags;
	}

	public function hasProperty(string $propertyName): bool
	{
		throw new ShouldNotHappenException();
	}

	public function hasMethod(string $methodName): bool
	{
		throw new ShouldNotHappenException();
	}

	public function getMethod(string $methodName, ClassMemberAccessAnswerer $scope): MethodReflection
	{
		throw new ShouldNotHappenException();
	}

	public function hasNativeMethod(string $methodName): bool
	{
		throw new ShouldNotHappenException();
	}

	public function getNativeMethod(string $methodName): MethodReflection
	{
		throw new ShouldNotHappenException();
	}

	/**
	 * @deprecated use ClassReflection::getNativeReflection() instead
	 *
	 * @return MethodReflection[]
	 */
	public function getNativeMethods(): array
	{
		throw new ShouldNotHappenException();
	}

	public function hasConstructor(): bool
	{
		throw new ShouldNotHappenException();
	}

	public function getConstructor(): MethodReflection
	{
		throw new ShouldNotHappenException();
	}

	public function getProperty(string $propertyName, ClassMemberAccessAnswerer $scope): PropertyReflection
	{
		throw new ShouldNotHappenException();
	}

	public function hasNativeProperty(string $propertyName): bool
	{
		throw new ShouldNotHappenException();
	}

	public function getNativeProperty(string $propertyName): PhpPropertyReflection
	{
		throw new ShouldNotHappenException();
	}

	public function hasConstant(string $name): bool
	{
		throw new ShouldNotHappenException();
	}

	public function getConstant(string $name): ConstantReflection
	{
		throw new ShouldNotHappenException();
	}

	/**
	 * {@inheritDoc}
	 */
	public function getResolvedPhpDoc(): ?ResolvedPhpDocBlock
	{
		return null;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getResolvedMixinTypes(): array
	{
		return [];
	}

	/**
	 * {@inheritDoc}
	 */
	public function getMixinTags(): array
	{
		return [];
	}

	/**
	 * {@inheritDoc}
	 */
	public function getPropertyTags(): array
	{
		return [];
	}

	/**
	 * {@inheritDoc}
	 */
	public function getMethodTags(): array
	{
		return [];
	}
}
