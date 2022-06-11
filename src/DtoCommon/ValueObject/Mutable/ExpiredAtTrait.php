<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable\ExpiredAtTrait as ExpiredAtImmutableTrait;

trait ExpiredAtTrait
{
    use ExpiredAtImmutableTrait;


    /**
     * @param string $expiredAt
     *
     * @return DtoInterface
     */
    protected function setExpiredAt(string $expiredAt): DtoInterface
    {
        $this->expiredAt = $expiredAt;

        return $this;
    }

}