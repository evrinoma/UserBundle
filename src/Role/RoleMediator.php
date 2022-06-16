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

final class RoleMediator implements RoleMediatorInterface
{
    public function revokePrivileges(array $roles): array
    {
        return [];
    }

    public function grantPrivileges(array $roles): array
    {
        return $roles;
    }
}
