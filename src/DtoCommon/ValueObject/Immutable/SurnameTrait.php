<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

trait SurnameTrait
{
//region SECTION: Fields
    private string $surname = '';
//endregion Fields

//region SECTION: Public
    /**
     * @return bool
     */
    public function hasSurname(): bool
    {
        return $this->surname !== '';
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }
//endregion Getters/Setters
}