<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable\UsernameTrait as UsernameImmutableTrait;

trait UsernameTrait
{
    use UsernameImmutableTrait;

//region SECTION: Getters/Setters

    /**
     * @param string $username
     *
     * @return DtoInterface
     */
    protected function setUsername(string $username): DtoInterface
    {
        $this->username = $username;

        return $this;
    }
//endregion Getters/Setters
}