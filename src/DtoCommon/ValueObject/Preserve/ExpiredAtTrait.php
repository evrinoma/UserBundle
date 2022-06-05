<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Preserve;

use Evrinoma\DtoBundle\Dto\DtoInterface;

trait ExpiredAtTrait
{
//region SECTION: Getters/Setters
    /**
     * @param string $expiredAt
     *
     * @return DtoInterface
     */
    public function setExpiredAt(string $expiredAt): DtoInterface
    {
        return parent::setExpiredAt($expiredAt);
    }
//endregion Getters/Setters
}