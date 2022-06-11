<?php

namespace Evrinoma\UserBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\NameInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable\EmailInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable\ExpiredAtInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable\PasswordInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable\PatronymicInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable\RolesInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable\SurnameInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable\UsernameInterface;

interface UserApiDtoInterface extends DtoInterface, IdInterface, ActiveInterface, NameInterface, PasswordInterface, UsernameInterface, EmailInterface, RolesInterface, SurnameInterface, PatronymicInterface, ExpiredAtInterface
{

    /**
     * @return bool
     */
    public function isActive(): bool;

}