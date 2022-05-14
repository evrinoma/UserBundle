<?php

namespace Evrinoma\UserBundle\Model;

interface ModelInterface
{
//region SECTION: Fields
    public const ID         = 'id';
    public const ACTIVE     = 'active';
    public const EMAIL      = 'email';
    public const USERNAME   = 'username';
    public const PASSWORD   = 'password';
    public const ROLES      = 'roles';
    public const NAME       = 'name';
    public const SURNAME    = 'surname';
    public const PATRONYMIC = 'patronymic';
    public const EXPIRED_AT = 'expired_at';
//endregion Fields
}