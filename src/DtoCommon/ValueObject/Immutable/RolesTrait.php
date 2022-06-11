<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

trait RolesTrait
{

    private array $roles        = [];
    private ?bool  $grant  = null;


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


    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

}