<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

trait UsernameTrait
{

    private string $username = '';


    /**
     * @return bool
     */
    public function hasUsername(): bool
    {
        return $this->username !== '';
    }


    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

}