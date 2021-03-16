<?php

namespace TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrapping;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
interface BasePackage
{
}
interface InnerPackage extends \TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrapping\BasePackage
{
}
/**
 * @template TInnerPackage of InnerPackage
 */
interface GenericPackage extends \TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrapping\BasePackage
{
    /** @return TInnerPackage */
    public function unwrap() : \TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrapping\InnerPackage;
}
interface SomeInnerPackage extends \TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrapping\InnerPackage
{
}
/**
 * @extends GenericPackage<SomeInnerPackage>
 */
interface SomePackage extends \TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrapping\GenericPackage
{
}
/**
 * @template TInnerPackage of InnerPackage
 * @template TGenericPackage of GenericPackage<TInnerPackage>
 * @param TGenericPackage $package
 * @return TInnerPackage
 */
function unwrapGeneric(\TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrapping\GenericPackage $package)
{
    $result = $package->unwrap();
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TInnerPackage of NestedGenericTypesUnwrapping\\InnerPackage (function NestedGenericTypesUnwrapping\\unwrapGeneric(), argument)', $result);
    return $result;
}
/**
 * @template TInnerPackage of InnerPackage
 * @template TGenericPackage of GenericPackage<TInnerPackage>
 * @param TGenericPackage $package
 * @return TGenericPackage
 */
function unwrapGeneric2(\TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrapping\GenericPackage $package)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TGenericPackage of NestedGenericTypesUnwrapping\\GenericPackage<TInnerPackage of NestedGenericTypesUnwrapping\\InnerPackage (function NestedGenericTypesUnwrapping\\unwrapGeneric2(), argument)> (function NestedGenericTypesUnwrapping\\unwrapGeneric2(), argument)', $package);
    return $package;
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
    $result = $package->unwrap();
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TInnerPackage of NestedGenericTypesUnwrapping\\InnerPackage (function NestedGenericTypesUnwrapping\\loadWithDirectUnwrap(), argument)', $result);
    return $result;
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
    $result = unwrapGeneric($package);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TInnerPackage of NestedGenericTypesUnwrapping\\InnerPackage (function NestedGenericTypesUnwrapping\\loadWithIndirectUnwrap(), argument)', $result);
    return $result;
}
/**
 * @template TInnerPackage of InnerPackage
 * @template TGenericPackage of GenericPackage<TInnerPackage>
 * @param  class-string<TGenericPackage> $class  FQCN to be instantiated
 * @return TGenericPackage
 */
function loadWithIndirectUnwrap2(string $class)
{
    $package = new $class();
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TGenericPackage of NestedGenericTypesUnwrapping\\GenericPackage<TInnerPackage of NestedGenericTypesUnwrapping\\InnerPackage (function NestedGenericTypesUnwrapping\\loadWithIndirectUnwrap2(), argument)> (function NestedGenericTypesUnwrapping\\loadWithIndirectUnwrap2(), argument)', $package);
    $result = unwrapGeneric2($package);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TGenericPackage of NestedGenericTypesUnwrapping\\GenericPackage<TInnerPackage of NestedGenericTypesUnwrapping\\InnerPackage (function NestedGenericTypesUnwrapping\\loadWithIndirectUnwrap2(), argument)> (function NestedGenericTypesUnwrapping\\loadWithIndirectUnwrap2(), argument)', $result);
    return $result;
}
function () : void {
    $result = loadWithDirectUnwrap(\TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrapping\SomePackage::class);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrapping\SomeInnerPackage::class, $result);
};
function () : void {
    $result = loadWithIndirectUnwrap(\TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrapping\SomePackage::class);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrapping\SomeInnerPackage::class, $result);
};
function () : void {
    $result = loadWithIndirectUnwrap2(\TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrapping\SomePackage::class);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrapping\SomePackage::class, $result);
};
function (\TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrapping\SomePackage $somePackage) : void {
    $result = unwrapGeneric($somePackage);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrapping\SomeInnerPackage::class, $result);
    $result = unwrapGeneric2($somePackage);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrapping\SomePackage::class, $result);
};
