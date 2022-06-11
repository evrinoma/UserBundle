<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;

interface PatronymicInterface
{

    /**
     * @param string $patronymic
     *
     * @return DtoInterface
     */
    public function setPatronymic(string $patronymic): DtoInterface;

}
