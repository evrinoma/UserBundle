<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

interface EmailInterface
{

    public const EMAIL = 'email';


    /**
     * @return bool
     */
    public function hasEmail(): bool;


    /**
     * @return string
     */
    public function getEmail(): string;


}