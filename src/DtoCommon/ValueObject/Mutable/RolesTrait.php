<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable\RolesTrait as RolesImmutableTrait;

trait RolesTrait
{
    use RolesImmutableTrait;


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

    /**
     * @return DtoInterface
     */
    protected function setGrant(): DtoInterface
    {
        $this->grant = true;

        return $this;
    }

    /**
     * @return DtoInterface
     */
    protected function resetGrant(): DtoInterface
    {
        $this->grant = false;

        return $this;
    }

}