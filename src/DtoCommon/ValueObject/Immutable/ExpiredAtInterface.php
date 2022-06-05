<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

interface ExpiredAtInterface
{
//region SECTION: Fields
    public const EXPIRED_AT = 'expired_at';
//endregion Fields
//region SECTION: Public
    /**
     * @return bool
     */
    public function hasExpiredAt(): bool;

    /**
     * @return bool
     */
    public function emptyExpiredAt(): bool;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getExpiredAt(): string;
//endregion Getters/Setters

}