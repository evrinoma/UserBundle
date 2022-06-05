<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;

interface SurnameInterface
{
//region SECTION: Getters/Setters
    /**
     * @param string $surname
     *
     * @return DtoInterface
     */
    public function setSurname(string $surname): DtoInterface;
//endregion Getters/Setters
}
