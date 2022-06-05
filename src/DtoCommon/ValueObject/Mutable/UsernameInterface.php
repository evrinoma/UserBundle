<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;

interface UsernameInterface
{
//region SECTION: Getters/Setters
    /**
     * @param string $username
     *
     * @return DtoInterface
     */
    public function setUsername(string $username): DtoInterface;
//endregion Getters/Setters
}
