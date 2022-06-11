<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

trait PatronymicTrait
{

    private string $patronymic = '';


    /**
     * @return bool
     */
    public function hasPatronymic(): bool
    {
        return $this->patronymic !== '';
    }


    /**
     * @return string
     */
    public function getPatronymic(): string
    {
        return $this->patronymic;
    }

}