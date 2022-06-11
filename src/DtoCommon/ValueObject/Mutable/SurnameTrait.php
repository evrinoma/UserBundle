<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable\SurnameTrait as SurnameImmutableTrait;

trait SurnameTrait
{
    use SurnameImmutableTrait;


    /**
     * @param string $surname
     *
     * @return DtoInterface
     */
    protected function setSurname(string $surname): DtoInterface
    {
        $this->surname = $surname;

        return $this;
    }

}