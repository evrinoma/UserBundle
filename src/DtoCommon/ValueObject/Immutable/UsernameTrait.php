<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

trait UsernameTrait
{
//region SECTION: Fields
    private string $username = '';
//endregion Fields

//region SECTION: Public
    /**
     * @return bool
     */
    public function hasUsername(): bool
    {
        return $this->username !== '';
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }
//endregion Getters/Setters
}