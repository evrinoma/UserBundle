<?php

namespace Evrinoma\UserBundle\RoleControl;

final class BasicRoleControl implements RoleControlInterface
{
//region SECTION: Public
    public function revokePrivileges(array $roles): array
    {
        return [];
    }

    public function grantPrivileges(array $roles): array
    {
        return $roles;
    }
//endregion Public
}