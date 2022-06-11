<?php


namespace Evrinoma\UserBundle\Role;

interface RoleMediatorInterface
{

    public function revokePrivileges(array $roles): array;

    public function grantPrivileges(array $roles): array;

}