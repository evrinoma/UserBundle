<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

interface RolesInterface
{

    public const ROLES       = 'roles';
    public const GRANT_ROLES = 'grant';


    /**
     * @return bool
     */
    public function hasRoles(): bool;

    /**
     * @return bool
     */
    public function isGranted(): bool;

    /**
     * @return bool
     */
    public function hasGranted(): bool;


    /**
     * @return array
     */
    public function getRoles(): array;


}