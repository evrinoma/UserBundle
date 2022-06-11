<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

trait RolesTrait
{
//region SECTION: Fields
    private array $roles        = [];
    private ?bool  $grant  = null;
//endregion Fields

//region SECTION: Public
    /**
     * @return bool
     */
    public function isGranted(): bool
    {
        return $this->grant;
    }

    /**
     * @return bool
     */
    public function hasGranted(): bool
    {
        return $this->grant !== null;
    }

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