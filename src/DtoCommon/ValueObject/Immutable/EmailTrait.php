<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

trait EmailTrait
{
//region SECTION: Fields
    private string $email = '';
//endregion Fields

//region SECTION: Public
    /**
     * @return bool
     */
    public function hasEmail(): bool
    {
        return $this->email !== '';
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
//endregion Getters/Setters
}