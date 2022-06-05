<?php

namespace Evrinoma\UserBundle\Dto\Preserve;

use Evrinoma\DtoCommon\ValueObject\Preserve\ActiveTrait;
use Evrinoma\DtoCommon\ValueObject\Preserve\IdTrait;
use Evrinoma\DtoCommon\ValueObject\Preserve\NameTrait;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Preserve\EmailTrait;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Preserve\ExpiredAtTrait;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Preserve\PasswordTrait;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Preserve\PatronymicTrait;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Preserve\RolesTrait;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Preserve\SurnameTrait;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Preserve\UsernameTrait;

trait UserApiDtoTrait
{
    use EmailTrait, ExpiredAtTrait, PasswordTrait, PatronymicTrait, RolesTrait, SurnameTrait, UsernameTrait, NameTrait, IdTrait, ActiveTrait;
}