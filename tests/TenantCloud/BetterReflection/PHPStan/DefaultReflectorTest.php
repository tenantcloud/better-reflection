<?php

namespace Tests\TenantCloud\BetterReflection\PHPStan;

use Ds\Pair;
use Ds\Sequence;
use Ds\Vector;
use PHPUnit\Framework\TestCase;
use TenantCloud\BetterReflection\DefaultReflectorBuilder;
use TenantCloud\BetterReflection\Projection\MethodReflectionProjection;
use TenantCloud\BetterReflection\Projection\ProjectionReflector;
use TenantCloud\BetterReflection\Projection\PropertyReflectionProjection;
use TenantCloud\BetterReflection\Reflection\FunctionParameterReflection;
use TenantCloud\BetterReflection\Reflection\TypeParameterReflection;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\FunctionVariant;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\GenericParametersAcceptorResolver;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\PassedByReference;
use TenantCloud\BetterReflection\Relocated\PHPStan\Reflection\Php\DummyParameter;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ArrayType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\GenericObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateGenericObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateMixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeMap;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeParameterStrategy;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeScope;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Generic\TemplateTypeVariance;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerRangeType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\IntegerType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\MixedType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\ObjectType;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\StringType;

class DefaultReflectorTest extends TestCase
{
	private ProjectionReflector $reflector;

	protected function setUp(): void
	{
		parent::setUp();

		$this->reflector = (new DefaultReflectorBuilder(__DIR__ . '/../../../../tmp'))->build();
	}

	public function testInferrenceWorksWithoutProvidingClass(): void
	{
		$templateTypeScope = TemplateTypeScope::createWithClass(ClassStub::class);

		$variant = GenericParametersAcceptorResolver::resolve([
			new GenericObjectType(
				SingleTemplateTypeImpl::class,
				[
					new ObjectType(ClassStub::class),
				]
			),
		], new FunctionVariant(
			templateTypeMap: new TemplateTypeMap([
				'TNested' => new MixedType(),
				'T'       => new GenericObjectType(
					SingleTemplateType::class,
					[
						$tNestedType = new TemplateMixedType(
							$templateTypeScope,
							new TemplateTypeParameterStrategy(),
							TemplateTypeVariance::createInvariant(),
							'TNested',
						),
					]
				),
			]),
			resolvedTemplateTypeMap: TemplateTypeMap::createEmpty(),
			parameters: [
				new DummyParameter(
					name: 'value',
					type: new TemplateGenericObjectType(
						$templateTypeScope,
						new TemplateTypeParameterStrategy(),
						TemplateTypeVariance::createInvariant(),
						'T',
						SingleTemplateType::class,
						[$tNestedType]
					),
					optional: false,
					passedByReference: PassedByReference::createNo(),
					variadic: false,
					defaultValue: null,
				),
			],
			isVariadic: false,
			returnType: new ArrayType(
				new MixedType(),
				$tNestedType
			),
		));

		self::assertEquals(
			new ArrayType(
				new MixedType(),
				new ObjectType(ClassStub::class),
			),
			$variant->getReturnType()
		);
	}

	public function testClassStub(): void
	{
		$reflection = $this->reflector->forClass(
			ClassStub::class,
			new TemplateTypeMap([
				'T' => $tType = new StringType(),
				'S' => $sType = IntegerRangeType::fromInterval(2, 15),
			])
		);

		self::assertSame(ClassStub::class, $reflection->qualifiedName());
		self::assertTrue($reflection->isFinal());
		self::assertFalse($reflection->isAbstract());
		self::assertFalse($reflection->isAnonymous());
		self::assertFalse($reflection->isBuiltIn());

		/** @var Sequence|TypeParameterReflection[] $typeParameters */
		$typeParameters = $reflection->typeParameters();
		self::assertCount(2, $typeParameters);

		$tTypeParameter = $typeParameters[0];
		self::assertSame('T', $tTypeParameter->name());
		self::assertEquals(new MixedType(), $tTypeParameter->upperBound());
		self::assertEquals(TemplateTypeVariance::createInvariant(), $tTypeParameter->variance());

		$tTypeParameter = $typeParameters[1];
		self::assertSame('S', $tTypeParameter->name());
		self::assertEquals(new IntegerType(), $tTypeParameter->upperBound());
		self::assertEquals(TemplateTypeVariance::createCovariant(), $tTypeParameter->variance());

		$attributes = $reflection->attributes();
		self::assertCount(1, $attributes);
		self::assertEquals(new AttributeStub('123'), $attributes[0]);

		$extends = $reflection->extends();
		self::assertNotNull($extends);
		self::assertEquals(
			new GenericObjectType(ParentClassStub::class, [
				$tType,
				new ObjectType(SomeStub::class),
			]),
			$extends
		);

		$implements = $reflection->implements();
		self::assertCount(1, $implements);
		self::assertEquals(
			new GenericObjectType(ParentInterfaceStub::class, [
				$tType,
				new ObjectType(SomeStub::class),
			]),
			$implements[0],
		);

		$uses = $reflection->uses();
		self::assertCount(1, $uses);
//		self::assertEquals(
//			new Vector([
//				new GenericObjectType(ParentTraitStub::class, [
//					new TemplateMixedType(
//						$templateTypeScope,
//						new TemplateTypeParameterStrategy(),
//						TemplateTypeVariance::createInvariant(),
//						'T',
//					),
//				]),
//			]),
//			$implements
//		);

		/** @var Sequence|PropertyReflectionProjection[] $properties */
		$properties = $reflection->properties();
		self::assertCount(2, $properties);

		$factoriesProperty = $properties[0];
		self::assertSame('factories', $factoriesProperty->name());
		self::assertEquals(
			new ArrayType(
				new MixedType(),
				new ObjectType(SomeStub::class)
			),
			$factoriesProperty->type()
		);
		self::assertEquals([
			new AttributeStub('4'),
		], $factoriesProperty->attributes()->toArray());

		$genericProperty = $properties[1];
		self::assertSame('generic', $genericProperty->name());
		self::assertEquals(
			new GenericObjectType(
				DoubleTemplateType::class,
				[
					new ObjectType(SomeStub::class),
					$tType,
				],
			),
			$genericProperty->type()
		);
		self::assertEmpty($genericProperty->attributes());

		/** @var Sequence|MethodReflectionProjection[] $methods */
		$methods = $reflection->methods();
		self::assertCount(2, $methods);

		$firstMethod = $methods[0];
		self::assertSame('method', $firstMethod->name());
		self::assertEquals([
			new AttributeStub('5'),
		], $firstMethod->attributes()->toArray());

		/** @var Sequence|TypeParameterReflection[] $typeParameters */
		$typeParameters = $firstMethod->typeParameters();
		self::assertCount(1, $typeParameters);
		self::assertSame('G', $typeParameters[0]->name());
		self::assertEquals(
			new TemplateMixedType(
				TemplateTypeScope::createWithMethod(ClassStub::class, 'method'),
				new TemplateTypeParameterStrategy(),
				TemplateTypeVariance::createInvariant(),
				'G',
			),
			$typeParameters[0]->upperBound()
		);
		self::assertEquals(TemplateTypeVariance::createInvariant(), $typeParameters[0]->variance());

		/** @var Sequence|FunctionParameterReflection[] $parameters */
		$parameters = $firstMethod->parameters();
		self::assertCount(1, $parameters);
		self::assertSame('param', $parameters[0]->name());
		self::assertEquals([
			new AttributeStub('6'),
		], $parameters[0]->attributes()->toArray());
		self::assertEquals(
			new GenericObjectType(
				DoubleTemplateType::class,
				[new ObjectType(SomeStub::class), $tType],
			),
			$parameters[0]->type(),
		);
		self::assertEquals(
			new GenericObjectType(
				Pair::class,
				[
					$sType,
					new TemplateMixedType(
						TemplateTypeScope::createWithMethod(ClassStub::class, 'method'),
						new TemplateTypeParameterStrategy(),
						TemplateTypeVariance::createInvariant(),
						'G',
					),
				],
			),
			$firstMethod->returnType()
		);

		$secondMethod = $methods[1];
		self::assertSame('methodTwo', $secondMethod->name());
		self::assertEmpty($secondMethod->attributes());

		/** @var Sequence|TypeParameterReflection[] $typeParameters */
		$typeParameters = $secondMethod->typeParameters();
		self::assertCount(2, $typeParameters);

		self::assertSame('KValue', $typeParameters[0]->name());
		self::assertEquals(
			$kValueTypeParam = new TemplateMixedType(
				TemplateTypeScope::createWithMethod(ClassStub::class, 'methodTwo'),
				new TemplateTypeParameterStrategy(),
				TemplateTypeVariance::createInvariant(),
				'KValue',
			),
			$typeParameters[0]->upperBound()
		);
		self::assertEquals(TemplateTypeVariance::createInvariant(), $typeParameters[0]->variance());

		self::assertSame('K', $typeParameters[1]->name());
		self::assertEquals(
			$kTypeParam = new TemplateGenericObjectType(
				TemplateTypeScope::createWithMethod(ClassStub::class, 'methodTwo'),
				new TemplateTypeParameterStrategy(),
				TemplateTypeVariance::createInvariant(),
				'K',
				SingleTemplateType::class,
				[$kValueTypeParam],
			),
			$typeParameters[1]->upperBound()
		);
		self::assertEquals(TemplateTypeVariance::createInvariant(), $typeParameters[1]->variance());

		/** @var Sequence|FunctionParameterReflection[] $parameters */
		$parameters = $secondMethod->parameters();
		self::assertCount(1, $parameters);
		self::assertSame('param', $parameters[0]->name());
		self::assertEmpty($parameters[0]->attributes());
		self::assertEquals($kTypeParam, $parameters[0]->type());
		self::assertEquals($kValueTypeParam, $secondMethod->returnType());
	}
}
