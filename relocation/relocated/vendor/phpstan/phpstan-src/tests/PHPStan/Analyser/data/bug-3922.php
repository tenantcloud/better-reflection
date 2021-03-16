<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3922;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
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
    public function handle(\TenantCloud\BetterReflection\Relocated\Bug3922\QueryInterface $query);
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
final class FooQuery implements \TenantCloud\BetterReflection\Relocated\Bug3922\QueryInterface
{
}
/**
 * @template-implements QueryInterface<BarQueryResult>
 */
final class BarQuery implements \TenantCloud\BetterReflection\Relocated\Bug3922\QueryInterface
{
}
final class FooQueryResult
{
}
final class BarQueryResult
{
}
/**
 * @template-implements QueryHandlerInterface<FooQueryResult, FooQuery>
 */
final class FooQueryHandler implements \TenantCloud\BetterReflection\Relocated\Bug3922\QueryHandlerInterface
{
    public function handle(\TenantCloud\BetterReflection\Relocated\Bug3922\QueryInterface $query)
    {
        return new \TenantCloud\BetterReflection\Relocated\Bug3922\FooQueryResult();
    }
}
function (\TenantCloud\BetterReflection\Relocated\Bug3922\FooQueryHandler $h) : void {
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\Bug3922\FooQueryResult::class, $h->handle(new \TenantCloud\BetterReflection\Relocated\Bug3922\FooQuery()));
    \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType(\TenantCloud\BetterReflection\Relocated\Bug3922\FooQueryResult::class, $h->handle(new \TenantCloud\BetterReflection\Relocated\Bug3922\BarQuery()));
};
