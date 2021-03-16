<?php

namespace Tests\TenantCloud\BetterReflection\PHPStan;

use Ds\Pair;

/**
 * @template T
 * @template-covariant S of int
 *
 * @extends ParentClassStub<T, SomeStub>
 * @implements ParentInterfaceStub<T, SomeStub>
 */
#[AttributeStub(something: '123')]
final class ClassStub extends ParentClassStub implements ParentInterfaceStub
{
	/* @use ParentTraitStub<T, SomeStub> */
	use ParentTraitStub;

	/** @var SomeStub[] */
	#[AttributeStub('4')]
	private array $factories;

	/** @var DoubleTemplateType<SomeStub, T> */
	private DoubleTemplateType $generic;

	/**
	 * @template G
	 *
	 * @param DoubleTemplateType<SomeStub, T> $param
	 *
	 * @return Pair<S, G>
	 */
	#[AttributeStub('5')]
	public function method(
		#[AttributeStub('6')] DoubleTemplateType $param
	): Pair {
	}

	/**
	 * @template KValue
	 * @template K of SingleTemplateType<KValue>
	 *
	 * @param K $param
	 *
	 * @return KValue
	 */
	public function methodTwo(mixed $param): mixed
	{
	}
}
