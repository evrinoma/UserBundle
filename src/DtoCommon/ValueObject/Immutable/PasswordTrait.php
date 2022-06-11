<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

trait PasswordTrait
{


    private string $password = '';


    public function hasPassword(): bool
    {
        return $this->password !== '';
    }


    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

}