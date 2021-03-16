<?php

namespace TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrappingCovariant;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
interface BasePackage
{
}
interface InnerPackage extends \TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrappingCovariant\BasePackage
{
}
/**
 * @template-covariant TInnerPackage of InnerPackage
 */
interface GenericPackage extends \TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrappingCovariant\BasePackage
{
    /** @return TInnerPackage */
    public function unwrap() : \TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrappingCovariant\InnerPackage;
}
interface SomeInnerPackage extends \TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrappingCovariant\InnerPackage
{
}
/**
 * @extends GenericPackage<SomeInnerPackage>
 */
interface SomePackage extends \TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrappingCovariant\GenericPackage
{
}
/**
 * @template TInnerPackage of InnerPackage
 * @template TGenericPackage of GenericPackage<TInnerPackage>
 * @param TGenericPackage $package
 * @return TInnerPackage
 */
function unwrapGeneric(\TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrappingCovariant\GenericPackage $package)
{
    $result = $package->unwrap();
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TInnerPackage of NestedGenericTypesUnwrappingCovariant\\InnerPackage (function NestedGenericTypesUnwrappingCovariant\\unwrapGeneric(), argument)', $result);
    return $result;
}
/**
 * @template TInnerPackage of InnerPackage
 * @template TGenericPackage of GenericPackage<TInnerPackage>
 * @param TGenericPackage $package
 * @return TGenericPackage
 */
function unwrapGeneric2(\TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrappingCovariant\GenericPackage $package)
{
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TGenericPackage of NestedGenericTypesUnwrappingCovariant\\GenericPackage<TInnerPackage of NestedGenericTypesUnwrappingCovariant\\InnerPackage (function NestedGenericTypesUnwrappingCovariant\\unwrapGeneric2(), argument)> (function NestedGenericTypesUnwrappingCovariant\\unwrapGeneric2(), argument)', $package);
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
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TInnerPackage of NestedGenericTypesUnwrappingCovariant\\InnerPackage (function NestedGenericTypesUnwrappingCovariant\\loadWithDirectUnwrap(), argument)', $result);
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
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TInnerPackage of NestedGenericTypesUnwrappingCovariant\\InnerPackage (function NestedGenericTypesUnwrappingCovariant\\loadWithIndirectUnwrap(), argument)', $result);
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
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TGenericPackage of NestedGenericTypesUnwrappingCovariant\\GenericPackage<TInnerPackage of NestedGenericTypesUnwrappingCovariant\\InnerPackage (function NestedGenericTypesUnwrappingCovariant\\loadWithIndirectUnwrap2(), argument)> (function NestedGenericTypesUnwrappingCovariant\\loadWithIndirectUnwrap2(), argument)', $package);
    $result = unwrapGeneric2($package);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('TGenericPackage of NestedGenericTypesUnwrappingCovariant\\GenericPackage<TInnerPackage of NestedGenericTypesUnwrappingCovariant\\InnerPackage (function NestedGenericTypesUnwrappingCovariant\\loadWithIndirectUnwrap2(), argument)> (function NestedGenericTypesUnwrappingCovariant\\loadWithIndirectUnwrap2(), argument)', $result);
    return $result;
}
function () : void {
    $result = loadWithDirectUnwrap(\TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrappingCovariant\SomePackage::class);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrappingCovariant\SomeInnerPackage::class, $result);
};
function () : void {
    $result = loadWithIndirectUnwrap(\TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrappingCovariant\SomePackage::class);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrappingCovariant\SomeInnerPackage::class, $result);
};
function () : void {
    $result = loadWithIndirectUnwrap2(\TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrappingCovariant\SomePackage::class);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrappingCovariant\SomePackage::class, $result);
};
function (\TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrappingCovariant\SomePackage $somePackage) : void {
    $result = unwrapGeneric($somePackage);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrappingCovariant\SomeInnerPackage::class, $result);
    $result = unwrapGeneric2($somePackage);
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\NestedGenericTypesUnwrappingCovariant\SomePackage::class, $result);
};
