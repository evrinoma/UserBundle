<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;

interface SurnameInterface
{

    /**
     * @param string $surname
     *
     * @return DtoInterface
     */
    public function setSurname(string $surname): DtoInterface;

}
