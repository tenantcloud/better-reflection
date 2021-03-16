<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3922Integration;

/**
 * @template TResult
 * @template TQuery of QueryInterface<TResult>
 */
interface QueryHandlerInterface
{
    /**
     * @param TQuery $query
     *
     * @return TResult
     */
    public function handle(\TenantCloud\BetterReflection\Relocated\Bug3922Integration\QueryInterface $query);
}
/**
 * @template TResult
 */
interface QueryInterface
{
}
/**
 * @template-implements QueryInterface<FooQueryResult>
 */
final class FooQuery implements \TenantCloud\BetterReflection\Relocated\Bug3922Integration\QueryInterface
{
}
final class FooQueryResult
{
}
/**
 * @template-implements QueryHandlerInterface<FooQueryResult, FooQuery>
 */
final class FooQueryHandler implements \TenantCloud\BetterReflection\Relocated\Bug3922Integration\QueryHandlerInterface
{
    public function handle(\TenantCloud\BetterReflection\Relocated\Bug3922Integration\QueryInterface $query) : \TenantCloud\BetterReflection\Relocated\Bug3922Integration\FooQueryResult
    {
        return new \TenantCloud\BetterReflection\Relocated\Bug3922Integration\FooQueryResult();
    }
}
interface BasePackage
{
}
interface InnerPackage extends \TenantCloud\BetterReflection\Relocated\Bug3922Integration\BasePackage
{
}
/**
 * @template TInnerPackage of InnerPackage
 */
interface GenericPackage extends \TenantCloud\BetterReflection\Relocated\Bug3922Integration\BasePackage
{
    /** @return TInnerPackage */
    public function unwrap() : \TenantCloud\BetterReflection\Relocated\Bug3922Integration\InnerPackage;
}
interface SomeInnerPackage extends \TenantCloud\BetterReflection\Relocated\Bug3922Integration\InnerPackage
{
}
/**
 * @extends GenericPackage<SomeInnerPackage>
 */
interface SomePackage extends \TenantCloud\BetterReflection\Relocated\Bug3922Integration\GenericPackage
{
}
/**
 * @template TInnerPackage of InnerPackage
 * @template TGenericPackage of GenericPackage<TInnerPackage>
 * @param TGenericPackage $package
 * @return TInnerPackage
 */
function unwrapGeneric(\TenantCloud\BetterReflection\Relocated\Bug3922Integration\GenericPackage $package)
{
    return $package->unwrap();
}
/**
 * @template TInnerPackage of InnerPackage
 * @template TGenericPackage of GenericPackage<TInnerPackage>
 * @param  class-string<TGenericPackage> $class  FQCN to be instantiated
 * @return TInnerPackage
 */
function loadWithDirectUnwrap(string $class)
{
    $package = new $class();
    return $package->unwrap();
}
/**
 * @template TInnerPackage of InnerPackage
 * @template TGenericPackage of GenericPackage<TInnerPackage>
 * @param  class-string<TGenericPackage> $class  FQCN to be instantiated
 * @return TInnerPackage
 */
function loadWithIndirectUnwrap(string $class)
{
    $package = new $class();
    return unwrapGeneric($package);
}
function () : void {
    loadWithDirectUnwrap(\TenantCloud\BetterReflection\Relocated\Bug3922Integration\SomePackage::class);
};
