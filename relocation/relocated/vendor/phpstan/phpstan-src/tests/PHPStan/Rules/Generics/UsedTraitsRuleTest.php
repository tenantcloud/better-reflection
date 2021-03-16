<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics;

use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper;
/**
 * @extends RuleTestCase<UsedTraitsRule>
 */
class UsedTraitsRuleTest extends \TenantCloud\BetterReflection\Relocated\PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
    {
        return new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\UsedTraitsRule(self::getContainer()->getByType(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper::class), new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\GenericAncestorsCheck($this->createReflectionProvider(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\GenericObjectTypeCheck(), new \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\VarianceCheck(), \true));
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/used-traits.php'], [['PHPDoc tag @use contains generic type UsedTraits\\NongenericTrait<stdClass> but trait UsedTraits\\NongenericTrait is not generic.', 20], ['Type int in generic type UsedTraits\\GenericTrait<int> in PHPDoc tag @use is not subtype of template type T of object of trait UsedTraits\\GenericTrait.', 31], ['Class UsedTraits\\Baz uses generic trait UsedTraits\\GenericTrait but does not specify its types: T', 38, 'You can turn this off by setting <fg=cyan>checkGenericClassInNonGenericObjectType: false</> in your <fg=cyan>%configurationFile%</>.'], ['Generic type UsedTraits\\GenericTrait<stdClass, Exception> in PHPDoc tag @use specifies 2 template types, but trait UsedTraits\\GenericTrait supports only 1: T', 46], ['The @use tag of trait UsedTraits\\NestedTrait describes UsedTraits\\NongenericTrait but the trait uses UsedTraits\\GenericTrait.', 54], ['Trait UsedTraits\\NestedTrait uses generic trait UsedTraits\\GenericTrait but does not specify its types: T', 54, 'You can turn this off by setting <fg=cyan>checkGenericClassInNonGenericObjectType: false</> in your <fg=cyan>%configurationFile%</>.']]);
    }
}
