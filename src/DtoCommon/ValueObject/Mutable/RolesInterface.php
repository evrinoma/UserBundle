<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;

interface RolesInterface
{

    /**
     * @return DtoInterface
     */
    public function setGrant(): DtoInterface;

    /**
     * @return DtoInterface
     */
    public function resetGrant(): DtoInterface;

    /**
     * @param array $roles
     *
     * @return DtoInterface
     */
    public function setRoles(array $roles): DtoInterface;

}
