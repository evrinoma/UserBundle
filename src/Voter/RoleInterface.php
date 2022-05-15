<?php

namespace Evrinoma\UserBundle\Voter;

interface RoleInterface
{
//region SECTION: Fields
    public const ROLE_USER        = 'ROLE_USER';
    public const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    public const ROLE_DEFAULT     = self::ROLE_USER;

    public const ROLE_USER_       = 'ROLE_USER_';
    public const ROLE_USER_CREATE = self::ROLE_USER_.'CREATE';
    public const ROLE_USER_EDIT   = self::ROLE_USER_.'EDIT';
//endregion Fields
}