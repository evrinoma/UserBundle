<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

interface RolesInterface
{
//region SECTION: Fields
    public const ROLES       = 'roles';
    public const GRANT_ROLES = 'grant';
//endregion Fields
//region SECTION: Public
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
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return array
     */
    public function getRoles(): array;
//endregion Getters/Setters

}