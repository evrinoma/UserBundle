<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

trait RolesTrait
{
//region SECTION: Fields
    private array $roles = [];
//endregion Fields

//region SECTION: Public
    /**
     * @return bool
     */
    public function hasRoles(): bool
    {
        return count($this->roles);
    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }
//endregion Getters/Setters
}