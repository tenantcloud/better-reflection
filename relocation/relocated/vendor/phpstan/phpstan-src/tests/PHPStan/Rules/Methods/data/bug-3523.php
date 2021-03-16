<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3523;

interface FooInterface
{
    /**
     * @return static
     */
    public function deserialize();
}
final class Foo implements \TenantCloud\BetterReflection\Relocated\Bug3523\FooInterface
{
    /**
     * @return static
     */
    public function deserialize() : self
    {
        return new self();
    }
}
class Bar implements \TenantCloud\BetterReflection\Relocated\Bug3523\FooInterface
{
    /**
     * @return static
     */
    public function deserialize() : self
    {
        return new self();
    }
}
class Baz implements \TenantCloud\BetterReflection\Relocated\Bug3523\FooInterface
{
    /**
     * @return self
     */
    public function deserialize() : self
    {
        return new self();
    }
}
