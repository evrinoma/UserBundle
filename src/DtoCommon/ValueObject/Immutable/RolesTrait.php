<?php

declare(strict_types=1);

/*
 * This file is part of the package.
 *
 * (c) Nikolay Nikolaev <evrinoma@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

trait RolesTrait
{
    private array $roles = [];
    private ?bool  $grant = null;

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
        return null !== $this->grant;
    }

    /**
     * @return bool
     */
    public function hasRoles(): bool
    {
        return \count($this->roles)!==0;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }
}
