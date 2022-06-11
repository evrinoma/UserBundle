<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Preserve;

use Evrinoma\DtoBundle\Dto\DtoInterface;

trait SurnameTrait
{

    /**
     * @param string $surname
     *
     * @return DtoInterface
     */
    public function setSurname(string $surname): DtoInterface
    {
        return parent::setSurname($surname);
    }

}