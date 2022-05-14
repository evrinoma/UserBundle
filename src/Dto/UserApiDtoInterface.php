<?php

namespace Evrinoma\UserBundle\Dto;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\IdInterface;

interface UserApiDtoInterface extends DtoInterface, IdInterface, ActiveInterface
{
//region SECTION: Public
    /**
     * @return bool
     */
    public function hasPassword(): bool;

    /**
     * @return bool
     */
    public function hasUsername(): bool;

    /**
     * @return bool
     */
    public function hasEmail(): bool;

    /**
     * @return bool
     */
    public function hasRoles(): bool;

    /**
     * @return bool
     */
    public function isActive(): bool;

    /**
     * @return bool
     */
    public function hasName(): bool;

    /**
     * @return bool
     */
    public function hasSurname(): bool;

    /**
     * @return bool
     */
    public function hasPatronymic(): bool;

    /**
     * @return bool
     */
    public function hasExpiredAt(): bool;

    /**
     * @return bool
     */
    public function emptyExpiredAt(): bool;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getPassword(): string;

    /**
     * @return string
     */
    public function getUsername(): string;

    /**
     * @return string
     */
    public function getEmail(): string;

    /**
     * @return array
     */
    public function getRoles(): array;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getSurname(): string;

    /**
     * @return string
     */
    public function getPatronymic(): string;

    /**
     * @return string
     */
    public function getExpiredAt(): string;
//endregion Getters/Setters
}