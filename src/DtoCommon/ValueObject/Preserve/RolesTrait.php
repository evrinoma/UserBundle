<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Preserve;

use Evrinoma\DtoBundle\Dto\DtoInterface;

trait RolesTrait
{
//region SECTION: Getters/Setters
    /**
     * @param array $roles
     *
     * @return DtoInterface
     */
    public function setRoles(array $roles): DtoInterface
    {
        return parent::setRoles($roles);
    }
//endregion Getters/Setters
}