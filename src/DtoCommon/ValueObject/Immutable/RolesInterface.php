<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

interface RolesInterface
{
//region SECTION: Fields
    public const ROLES = 'roles';
//endregion Fields
//region SECTION: Public
    /**
     * @return bool
     */
    public function hasRoles(): bool;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return array
     */
    public function getRoles(): array;
//endregion Getters/Setters

}