<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

interface SurnameInterface
{
//region SECTION: Fields
    public const SURNAME = 'surname';
//endregion Fields
//region SECTION: Public
    /**
     * @return bool
     */
    public function hasSurname(): bool;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getSurname(): string;
//endregion Getters/Setters

}