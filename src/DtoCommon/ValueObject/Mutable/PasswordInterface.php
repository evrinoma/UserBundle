<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;

interface PasswordInterface
{
//region SECTION: Getters/Setters
    /**
     * @param string $password
     *
     * @return DtoInterface
     */
    public function setPassword(string $password): DtoInterface;
//endregion Getters/Setters
}
