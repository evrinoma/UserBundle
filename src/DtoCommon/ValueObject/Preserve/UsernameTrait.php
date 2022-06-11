<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Preserve;

use Evrinoma\DtoBundle\Dto\DtoInterface;

trait UsernameTrait
{

    /**
     * @param string $username
     *
     * @return DtoInterface
     */
    public function setUsername(string $username): DtoInterface
    {
        return parent::setUsername($username);
    }

}