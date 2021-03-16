<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3922Ancestors;

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
    public function handle(\TenantCloud\BetterReflection\Relocated\Bug3922Ancestors\QueryInterface $query);
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
final class FooQuery implements \TenantCloud\BetterReflection\Relocated\Bug3922Ancestors\QueryInterface
{
}
/**
 * @template-implements QueryInterface<int>
 */
final class BarQuery implements \TenantCloud\BetterReflection\Relocated\Bug3922Ancestors\QueryInterface
{
}
/**
 * @template-implements QueryHandlerInterface<string, FooQuery>
 */
final class FooQueryHandler implements \TenantCloud\BetterReflection\Relocated\Bug3922Ancestors\QueryHandlerInterface
{
    public function handle(\TenantCloud\BetterReflection\Relocated\Bug3922Ancestors\QueryInterface $query) : string
    {
        return 'foo';
    }
}
/**
 * @template-implements QueryHandlerInterface<string, BarQuery>
 */
final class BarQueryHandler implements \TenantCloud\BetterReflection\Relocated\Bug3922Ancestors\QueryHandlerInterface
{
    public function handle(\TenantCloud\BetterReflection\Relocated\Bug3922Ancestors\QueryInterface $query) : int
    {
        return 10;
    }
}
