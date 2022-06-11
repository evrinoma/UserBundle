<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

interface SurnameInterface
{

    public const SURNAME = 'surname';


    /**
     * @return bool
     */
    public function hasSurname(): bool;


    /**
     * @return string
     */
    public function getSurname(): string;


}