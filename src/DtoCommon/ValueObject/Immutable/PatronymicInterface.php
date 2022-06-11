<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

interface PatronymicInterface
{

    public const PATRONYMIC = 'patronymic';


    /**
     * @return bool
     */
    public function hasPatronymic(): bool;


    /**
     * @return string
     */
    public function getPatronymic(): string;


}