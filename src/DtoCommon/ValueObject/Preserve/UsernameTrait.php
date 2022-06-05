<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Preserve;

use Evrinoma\DtoBundle\Dto\DtoInterface;

trait UsernameTrait
{
//region SECTION: Getters/Setters
    /**
     * @param string $username
     *
     * @return DtoInterface
     */
    public function setUsername(string $username): DtoInterface
    {
        return parent::setUsername($username);
    }
//endregion Getters/Setters
}