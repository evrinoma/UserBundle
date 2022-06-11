<?php

namespace Evrinoma\UserBundle\Role;

final class BasicRoleMediator implements RoleMediatorInterface
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