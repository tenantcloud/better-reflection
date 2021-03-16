<?php

namespace TenantCloud\BetterReflection\Relocated\Bug4642;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
interface IEntity
{
}
/** @template E of IEntity */
interface IRepository
{
}
interface I
{
    /**
     * Returns repository by repository class.
     * @template E of IEntity
     * @template T of IRepository<E>
     * @phpstan-param class-string<T> $className
     * @phpstan-return T
     */
    function getRepository(string $className) : \TenantCloud\BetterReflection\Relocated\Bug4642\IRepository;
}
class User implements \TenantCloud\BetterReflection\Relocated\Bug4642\IEntity
{
}
/** @implements IRepository<User> */
class UsersRepository implements \TenantCloud\BetterReflection\Relocated\Bug4642\IRepository
{
}
function (\TenantCloud\BetterReflection\Relocated\Bug4642\I $model) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\Bug4642\UsersRepository::class, $model->getRepository(\TenantCloud\BetterReflection\Relocated\Bug4642\UsersRepository::class));
};
