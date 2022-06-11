<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

interface UsernameInterface
{

    public const USERNAME = 'username';


    /**
     * @return bool
     */
    public function hasUsername(): bool;


    /**
     * @return string
     */
    public function getUsername(): string;


}