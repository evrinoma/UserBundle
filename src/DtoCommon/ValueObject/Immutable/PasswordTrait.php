<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

trait PasswordTrait
{

//region SECTION: Fields
    private string $password = '';
//endregion Fields

//region SECTION: Public
    public function hasPassword(): bool
    {
        return $this->password !== '';
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
//endregion Getters/Setters
}