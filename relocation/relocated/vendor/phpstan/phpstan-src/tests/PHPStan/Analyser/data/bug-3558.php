<?php

namespace TenantCloud\BetterReflection\Relocated\Bug3558;

use function TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType;
function () : void {
    $idGroups = [];
    if (\time() > 3) {
        $idGroups[] = [1, 2];
        $idGroups[] = [1, 2];
        $idGroups[] = [1, 2];
    }
    if (\count($idGroups) > 0) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(array(1, 2), array(1, 2), array(1, 2))', $idGroups);
    }
};
function () : void {
    $idGroups = [1];
    if (\time() > 3) {
        $idGroups[] = [1, 2];
        $idGroups[] = [1, 2];
        $idGroups[] = [1, 2];
    }
    if (\count($idGroups) > 1) {
        \TenantCloud\BetterReflection\Relocated\PHPStan\Analyser\assertType('array(0 => 1, ?1 => array(1, 2), ?2 => array(1, 2), ?3 => array(1, 2))', $idGroups);
    }
};
