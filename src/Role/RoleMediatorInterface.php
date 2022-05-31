<?php


namespace Evrinoma\UserBundle\Role;

interface RoleMediatorInterface
{
//region SECTION: Public
    public function revokePrivileges(array $roles): array;

    public function grantPrivileges(array $roles): array;
//endregion Public
}