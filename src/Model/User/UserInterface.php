<?php

namespace Evrinoma\UserBundle\Model\User;

use DateTimeImmutable;
use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;

interface UserInterface extends BaseUserInterface
{
    public function addRole(string $role): void;

    public function hasRole(string $role): bool;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return DateTimeImmutable|null
     */
    public function getLastLogin(): ?DateTimeImmutable;

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
    public function getName(): string;

    /**
     * @return string
     */
    public function getPatronymic(): string;

    /**
     * @return DateTimeImmutable|null
     */
    public function getExpiredAt(): ?DateTimeImmutable;

    /**
     * @return string
     */
    public function getPlainPassword(): string;

    /**
     * @param DateTimeImmutable|null $lastLogin
     */
    public function setLastLogin(?DateTimeImmutable $lastLogin): void;

    /**
     * @param string $email
     */
    public function setEmail(string $email): void;

    /**
     * @param string $surname
     */
    public function setSurname(string $surname): void;

    /**
     * @param string $name
     */
    public function setName(string $name): void;

    /**
     * @param string $patronymic
     */
    public function setPatronymic(string $patronymic): void;

    /**
     * @param DateTimeImmutable|null $expiredAt
     */
    public function setExpiredAt(?DateTimeImmutable $expiredAt): void;

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword(string $plainPassword): void;
}