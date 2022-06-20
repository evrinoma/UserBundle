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

namespace Evrinoma\UserBundle\Role;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UserBundle\Dto\UserApiDtoInterface;

final class RoleMediator implements RoleMediatorInterface
{
    public function revokePrivileges(DtoInterface $dto, array $roles): array
    {
        return [];
    }

    public function grantPrivileges(DtoInterface $dto): array
    {
        /* @var UserApiDtoInterface $dto */
        return $dto->getRoles();
    }
}
