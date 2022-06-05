<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

interface EmailInterface
{
//region SECTION: Fields
    public const EMAIL = 'email';
//endregion Fields
//region SECTION: Public
    /**
     * @return bool
     */
    public function hasEmail(): bool;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getEmail(): string;
//endregion Getters/Setters

}