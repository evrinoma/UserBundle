<?php


namespace Evrinoma\UserBundle\RoleControl;

interface RoleControlInterface
{
//region SECTION: Public
    public function revokePrivileges(array $roles): array;

    public function grantPrivileges(array $roles): array;
//endregion Public
}