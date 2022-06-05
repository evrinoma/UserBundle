<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable\RolesTrait as RolesImmutableTrait;

trait RolesTrait
{
    use RolesImmutableTrait;

//region SECTION: Getters/Setters

    /**
     * @param array $roles
     *
     * @return DtoInterface
     */
    protected function setRoles(array $roles): DtoInterface
    {
        $this->roles = $roles;

        return $this;
    }
//endregion Getters/Setters
}