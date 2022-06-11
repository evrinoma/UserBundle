<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

trait SurnameTrait
{

    private string $surname = '';


    /**
     * @return bool
     */
    public function hasSurname(): bool
    {
        return $this->surname !== '';
    }


    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

}