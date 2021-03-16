<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3922AncestorsReversed;

/**
 * @template TQuery of QueryInterface<TResult>
 * @template TResult
 */
interface QueryHandlerInterface
{
    /**
     * @param TQuery $query
     *
     * @return TResult
     */
    public function handle(\TenantCloud\BetterReflection\Relocated\Bug3922AncestorsReversed\QueryInterface $query);
}
/**
 * @template TResult
 */
interface QueryInterface
{
}
/**
 * @template-implements QueryInterface<string>
 */
final class FooQuery implements \TenantCloud\BetterReflection\Relocated\Bug3922AncestorsReversed\QueryInterface
{
}
/**
 * @template-implements QueryInterface<int>
 */
final class BarQuery implements \TenantCloud\BetterReflection\Relocated\Bug3922AncestorsReversed\QueryInterface
{
}
/**
 * @template-implements QueryHandlerInterface<FooQuery, string>
 */
final class FooQueryHandler implements \TenantCloud\BetterReflection\Relocated\Bug3922AncestorsReversed\QueryHandlerInterface
{
    public function handle(\TenantCloud\BetterReflection\Relocated\Bug3922AncestorsReversed\QueryInterface $query) : string
    {
        return 'foo';
    }
}
/**
 * @template-implements QueryHandlerInterface<BarQuery, string>
 */
final class BarQueryHandler implements \TenantCloud\BetterReflection\Relocated\Bug3922AncestorsReversed\QueryHandlerInterface
{
    public function handle(\TenantCloud\BetterReflection\Relocated\Bug3922AncestorsReversed\QueryInterface $query) : int
    {
        return 10;
    }
}
