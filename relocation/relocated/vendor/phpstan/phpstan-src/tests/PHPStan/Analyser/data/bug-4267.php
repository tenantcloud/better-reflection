<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4267;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
/**
 * @implements \IteratorAggregate<int, static>
 */
class Model1 implements \IteratorAggregate
{
    public function getIterator() : iterable
    {
        throw new \Exception('not implemented');
    }
}
class HelloWorld1 extends \TenantCloud\BetterReflection\Relocated\Bug4267\Model1
{
    /** @var int */
    public $x = 5;
}
function () : void {
    foreach (new \TenantCloud\BetterReflection\Relocated\Bug4267\HelloWorld1() as $h) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\Bug4267\HelloWorld1::class, $h);
    }
};
class Model2 implements \IteratorAggregate
{
    /**
     * @return iterable<static>
     */
    public function getIterator() : iterable
    {
        throw new \Exception('not implemented');
    }
}
class HelloWorld2 extends \TenantCloud\BetterReflection\Relocated\Bug4267\Model2
{
    /** @var int */
    public $x = 5;
}
function () : void {
    foreach (new \TenantCloud\BetterReflection\Relocated\Bug4267\HelloWorld2() as $h) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\Bug4267\HelloWorld2::class, $h);
    }
};
