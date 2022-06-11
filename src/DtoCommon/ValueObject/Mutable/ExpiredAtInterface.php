<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;

interface ExpiredAtInterface
{

    /**
     * @param string $expiredAt
     *
     * @return DtoInterface
     */
    public function setExpiredAt(string $expiredAt): DtoInterface;

}
