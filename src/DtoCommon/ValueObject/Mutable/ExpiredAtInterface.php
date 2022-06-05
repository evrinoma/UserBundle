<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;

interface ExpiredAtInterface
{
//region SECTION: Getters/Setters
    /**
     * @param string $expiredAt
     *
     * @return DtoInterface
     */
    public function setExpiredAt(string $expiredAt): DtoInterface;
//endregion Getters/Setters
}
