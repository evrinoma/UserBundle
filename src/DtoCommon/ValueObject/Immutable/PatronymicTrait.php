<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

trait PatronymicTrait
{
//region SECTION: Fields
    private string $patronymic = '';
//endregion Fields

//region SECTION: Public
    /**
     * @return bool
     */
    public function hasPatronymic(): bool
    {
        return $this->patronymic !== '';
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getPatronymic(): string
    {
        return $this->patronymic;
    }
//endregion Getters/Setters
}