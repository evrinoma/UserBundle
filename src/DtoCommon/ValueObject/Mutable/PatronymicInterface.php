<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;

interface PatronymicInterface
{
//region SECTION: Getters/Setters
    /**
     * @param string $patronymic
     *
     * @return DtoInterface
     */
    public function setPatronymic(string $patronymic): DtoInterface;
//endregion Getters/Setters
}
