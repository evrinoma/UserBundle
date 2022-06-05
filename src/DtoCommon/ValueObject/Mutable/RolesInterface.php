<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;

interface RolesInterface
{
//region SECTION: Getters/Setters
    /**
     * @param array $roles
     *
     * @return DtoInterface
     */
    public function setRoles(array $roles): DtoInterface;
//endregion Getters/Setters
}
