<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable\PasswordTrait as PasswordImmutableTrait;

trait PasswordTrait
{
    use PasswordImmutableTrait;


    /**
     * @param string $password
     *
     * @return DtoInterface
     */
    protected function setPassword(string $password): DtoInterface
    {
        $this->password = $password;

        return $this;
    }

}