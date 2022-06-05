<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

interface UsernameInterface
{
//region SECTION: Fields
    public const USERNAME = 'username';
//endregion Fields
//region SECTION: Public
    /**
     * @return bool
     */
    public function hasUsername(): bool;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getUsername(): string;
//endregion Getters/Setters

}