<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;

interface UsernameInterface
{

    /**
     * @param string $username
     *
     * @return DtoInterface
     */
    public function setUsername(string $username): DtoInterface;

}
