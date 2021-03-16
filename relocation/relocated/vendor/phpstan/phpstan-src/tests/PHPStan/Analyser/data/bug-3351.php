<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
class HelloWorld
{
    public function sayHello() : void
    {
        $a = ['a', 'b', 'c'];
        $b = [1, 2, 3];
        $c = $this->combine($a, $b);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array<string, int>|false', $c);
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(\'a\' => 1, \'b\' => 2, \'c\' => 3)', \array_combine($a, $b));
    }
    /**
     * @template TKey
     * @template TValue
     * @param array<TKey> $keys
     * @param array<TValue> $values
     *
     * @return array<TKey, TValue>|false
     */
    private function combine(array $keys, array $values)
    {
        return \array_combine($keys, $values);
    }
}
