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

namespace Evrinoma\UserBundle\Model\User;

use DateTimeImmutable;
use Evrinoma\UtilsBundle\Entity\ActiveInterface;
use Evrinoma\UtilsBundle\Entity\IdInterface;
use Evrinoma\UtilsBundle\Entity\NameInterface;
use Symfony\Component\Security\Core\User\LegacyPasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;

interface UserInterface extends PasswordAuthenticatedUserInterface, LegacyPasswordAuthenticatedUserInterface, BaseUserInterface, ActiveInterface, IdInterface, NameInterface
{
    /**
     * @param string $role
     *
     * @return UserInterface
     */
    public function addRole(string $role): UserInterface;

    /**
     * @param string $role
     *
     * @return bool
     */
    public function hasRole(string $role): bool;

    /**
     * @return bool
     */
    public function hasExpiredAt(): bool;

    /**
     * @return DateTimeImmutable|null
     */
    public function getLastLogin(): ?DateTimeImmutable;

    /**
     * @return string
     */
    public function getFio(): string;

    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @return string
     */
    public function getSurname(): string;

    /**
     * @return string
     */
    public function getPatronymic(): string;

    /**
     * @return DateTimeImmutable|null
     */
    public function getExpiredAt(): ?DateTimeImmutable;

    /**
     * @param DateTimeImmutable|null $lastLogin
     *
     * @return UserInterface
     */
    public function setLastLogin(?DateTimeImmutable $lastLogin): UserInterface;

    /**
     * @param string $email
     *
     * @return UserInterface
     */
    public function setEmail(string $email): UserInterface;

    /**
     * @param string $surname
     *
     * @return UserInterface
     */
    public function setSurname(string $surname): UserInterface;

    /**
     * @param string $patronymic
     *
     * @return UserInterface
     */
    public function setPatronymic(string $patronymic): UserInterface;

    /**
     * @param DateTimeImmutable|null $expiredAt
     *
     * @return UserInterface
     */
    public function setExpiredAt(?DateTimeImmutable $expiredAt): UserInterface;

    /**
     * @param string $password
     *
     * @return UserInterface
     */
    public function setPassword(string $password): UserInterface;

    /**
     * @param string $username
     *
     * @return UserInterface
     */
    public function setUsername(string $username): UserInterface;

    /**
     * @param array $roles
     *
     * @return UserInterface
     */
    public function setRoles(array $roles): UserInterface;
}
