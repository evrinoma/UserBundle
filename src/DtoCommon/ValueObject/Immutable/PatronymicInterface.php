<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

interface PatronymicInterface
{
//region SECTION: Fields
    public const PATRONYMIC = 'patronymic';
//endregion Fields
//region SECTION: Public
    /**
     * @return bool
     */
    public function hasPatronymic(): bool;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getPatronymic(): string;
//endregion Getters/Setters

}