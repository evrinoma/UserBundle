<?php


namespace Evrinoma\UserBundle\Dto\Preserve;


use Evrinoma\DtoCommon\ValueObject\Mutable\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\NameInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable\EmailInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable\ExpiredAtInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable\PasswordInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable\PatronymicInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable\RolesInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable\SurnameInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable\UsernameInterface;

interface UserApiDtoInterface extends IdInterface, ActiveInterface, NameInterface, PasswordInterface, UsernameInterface, EmailInterface, RolesInterface, SurnameInterface, PatronymicInterface, ExpiredAtInterface
{
}