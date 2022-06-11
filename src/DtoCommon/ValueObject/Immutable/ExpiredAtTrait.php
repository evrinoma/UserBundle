<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

trait ExpiredAtTrait
{

    private ?string $expiredAt = null;


    /**
     * @return bool
     */
    public function hasExpiredAt(): bool
    {
        return $this->expiredAt !== null;
    }

    /**
     * @return bool
     */
    public function emptyExpiredAt(): bool
    {
        return $this->expiredAt === '';
    }


    /**
     * @return string
     */
    public function getExpiredAt(): string
    {
        return $this->expiredAt;
    }

}