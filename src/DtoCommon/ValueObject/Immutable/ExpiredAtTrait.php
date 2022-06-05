<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

trait ExpiredAtTrait
{
//region SECTION: Fields
    private ?string $expiredAt = null;
//endregion Fields

//region SECTION: Public
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
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getExpiredAt(): string
    {
        return $this->expiredAt;
    }
//endregion Getters/Setters
}