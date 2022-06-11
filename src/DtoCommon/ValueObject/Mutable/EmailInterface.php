<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;

interface EmailInterface
{

    /**
     * @param string $email
     *
     * @return DtoInterface
     */
    public function setEmail(string $email): DtoInterface;

}
