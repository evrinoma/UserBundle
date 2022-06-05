<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Preserve;

use Evrinoma\DtoBundle\Dto\DtoInterface;

trait PasswordTrait
{
//region SECTION: Getters/Setters
    /**
     * @param string $password
     *
     * @return DtoInterface
     */
    public function setPassword(string $password): DtoInterface
    {
        return parent::setPassword($password);
    }
//endregion Getters/Setters
}