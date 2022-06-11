<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Preserve;

use Evrinoma\DtoBundle\Dto\DtoInterface;

trait PatronymicTrait
{

    /**
     * @param string $patronymic
     *
     * @return DtoInterface
     */
    public function setPatronymic(string $patronymic): DtoInterface
    {
        return parent::setPatronymic($patronymic);
    }

}