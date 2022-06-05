<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

interface PasswordInterface
{
//region SECTION: Fields
    public const PASSWORD = 'password';
//endregion Fields
//region SECTION: Public
    /**
     * @return bool
     */
    public function hasPassword(): bool;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getPassword(): string;
//endregion Getters/Setters

}