<?php

declare (strict_types=1);
namespace TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics;

use TenantCloud\BetterReflection\Relocated\PhpParser\Node;
use TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope;
use TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\UsesTag;
use TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper;
use TenantCloud\BetterReflection\Relocated\PHPStan\Type\Type;
/**
 * @implements \PHPStan\Rules\Rule<\PhpParser\Node\Stmt\TraitUse>
 */
class UsedTraitsRule implements \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Rule
{
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper $fileTypeMapper;
    private \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\GenericAncestorsCheck $genericAncestorsCheck;
    public function __construct(\TenantCloud\BetterReflection\Relocated\PHPStan\Type\FileTypeMapper $fileTypeMapper, \TenantCloud\BetterReflection\Relocated\PHPStan\Rules\Generics\GenericAncestorsCheck $genericAncestorsCheck)
    {
        $this->fileTypeMapper = $fileTypeMapper;
        $this->genericAncestorsCheck = $genericAncestorsCheck;
    }
    public function getNodeType() : string
    {
        return \TenantCloud\BetterReflection\Relocated\PhpParser\Node\Stmt\TraitUse::class;
    }
    public function processNode(\TenantCloud\BetterReflection\Relocated\PhpParser\Node $node, \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\Scope $scope) : array
    {
        if (!$scope->isInClass()) {
            throw new \TenantCloud\BetterReflection\Relocated\PHPStan\ShouldNotHappenException();
        }
        $className = $scope->getClassReflection()->getName();
        $traitName = null;
        if ($scope->isInTrait()) {
            $traitName = $scope->getTraitReflection()->getName();
        }
        $useTags = [];
        $docComment = $node->getDocComment();
        if ($docComment !== null) {
            $resolvedPhpDoc = $this->fileTypeMapper->getResolvedPhpDoc($scope->getFile(), $className, $traitName, null, $docComment->getText());
            $useTags = $resolvedPhpDoc->getUsesTags();
        }
        $description = \sprintf('class %s', $className);
        $typeDescription = 'class';
        if ($traitName !== null) {
            $description = \sprintf('trait %s', $traitName);
            $typeDescription = 'trait';
        }
        return $this->genericAncestorsCheck->check($node->traits, \array_map(static function (\TenantCloud\BetterReflection\Relocated\PHPStan\PhpDoc\Tag\UsesTag $tag) : Type {
            return $tag->getType();
        }, $useTags), \sprintf('%s @use tag contains incompatible type %%s.', \ucfirst($description)), \sprintf('%s has @use tag, but does not use any trait.', \ucfirst($description)), \sprintf('The @use tag of %s describes %%s but the %s uses %%s.', $description, $typeDescription), 'PHPDoc tag @use contains generic type %s but trait %s is not generic.', 'Generic type %s in PHPDoc tag @use does not specify all template types of trait %s: %s', 'Generic type %s in PHPDoc tag @use specifies %d template types, but trait %s supports only %d: %s', 'Type %s in generic type %s in PHPDoc tag @use is not subtype of template type %s of trait %s.', 'PHPDoc tag @use has invalid type %s.', \sprintf('%s uses generic trait %%s but does not specify its types: %%s', \ucfirst($description)), \sprintf('in used type %%s of %s', $description));
    }
}
