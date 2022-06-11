<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

interface PasswordInterface
{

    public const PASSWORD = 'password';


    /**
     * @return bool
     */
    public function hasPassword(): bool;


    /**
     * @return string
     */
    public function getPassword(): string;


}