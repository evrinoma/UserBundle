<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable\PatronymicTrait as PatronymicImmutableTrait;

trait PatronymicTrait
{
    use PatronymicImmutableTrait;


    /**
     * @param string $patronymic
     *
     * @return DtoInterface
     */
    protected function setPatronymic(string $patronymic): DtoInterface
    {
        $this->patronymic = $patronymic;

        return $this;
    }

}