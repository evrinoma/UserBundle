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
    use ActiveTrait;
    use EmailTrait;
    use ExpiredAtTrait;
    use IdTrait;
    use NameTrait;
    use PasswordTrait;
    use PatronymicTrait;
    use RolesTrait;
    use SurnameTrait;
    use UsernameTrait;
}
