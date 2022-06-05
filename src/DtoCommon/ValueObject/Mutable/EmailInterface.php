<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;

interface EmailInterface
{
//region SECTION: Getters/Setters
    /**
     * @param string $email
     *
     * @return DtoInterface
     */
    public function setEmail(string $email): DtoInterface;
//endregion Getters/Setters
}
