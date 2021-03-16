<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4643;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
interface Entity
{
}
class User implements \TenantCloud\BetterReflection\Relocated\Bug4643\Entity
{
}
class Admin extends \TenantCloud\BetterReflection\Relocated\Bug4643\User
{
}
class Article implements \TenantCloud\BetterReflection\Relocated\Bug4643\Entity
{
}
/** @template E of Entity */
class Repository
{
    /**
     * @template F of E
     * @param F $entity
     * @return F
     */
    function store(\TenantCloud\BetterReflection\Relocated\Bug4643\Entity $entity) : \TenantCloud\BetterReflection\Relocated\Bug4643\Entity
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('F of E of Bug4643\\Entity (class Bug4643\\Repository, argument) (method Bug4643\\Repository::store(), argument)', $entity);
        return $entity;
    }
}
/** @extends Repository<User> */
class UserRepository extends \TenantCloud\BetterReflection\Relocated\Bug4643\Repository
{
    function store(\TenantCloud\BetterReflection\Relocated\Bug4643\Entity $entity) : \TenantCloud\BetterReflection\Relocated\Bug4643\Entity
    {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('F of Bug4643\\User (method Bug4643\\Repository::store(), argument)', $entity);
        return $entity;
    }
}
function (\TenantCloud\BetterReflection\Relocated\Bug4643\UserRepository $r) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\Bug4643\User::class, $r->store(new \TenantCloud\BetterReflection\Relocated\Bug4643\User()));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\Bug4643\Admin::class, $r->store(new \TenantCloud\BetterReflection\Relocated\Bug4643\Admin()));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('F of Bug4643\\User (method Bug4643\\Repository::store(), parameter)', $r->store(new \TenantCloud\BetterReflection\Relocated\Bug4643\Article()));
    // should be User::class, but inheriting template tags is now broken like that
};
