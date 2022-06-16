<?php

declare(strict_types=1);

/*
 * This file is part of the package.
 *
 * (c) Nikolay Nikolaev <evrinoma@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evrinoma\UserBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\NameInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable\EmailInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable\ExpiredAtInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable\GrantInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable\PasswordInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable\PatronymicInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable\RolesInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable\SurnameInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable\UsernameInterface;

interface UserApiDtoInterface extends DtoInterface, IdInterface, ActiveInterface, NameInterface, PasswordInterface, UsernameInterface, EmailInterface, RolesInterface, GrantInterface, SurnameInterface, PatronymicInterface, ExpiredAtInterface
{
}
