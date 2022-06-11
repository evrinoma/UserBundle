<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

trait EmailTrait
{

    private string $email = '';


    /**
     * @return bool
     */
    public function hasEmail(): bool
    {
        return $this->email !== '';
    }


    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

}