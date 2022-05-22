<?php

namespace Evrinoma\UserBundle\Dto;

use Evrinoma\DtoCommon\ValueObject\Mutable\NameTrait;
use Evrinoma\UserBundle\Model\ModelInterface;
use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\ActiveTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdTrait;
use Evrinoma\UtilsBundle\Model\ActiveModel;
use Symfony\Component\HttpFoundation\Request;

final class UserApiDto extends AbstractDto implements UserApiDtoInterface
{
    use ActiveTrait, IdTrait, NameTrait;

//region SECTION: Fields
    private string $username = '';
    private string $password = '';
    private string $email    = '';

    private string  $surname    = '';
    private string  $patronymic = '';
    private ?string $expiredAt  = null;
    private array   $roles      = [];
//endregion Fields

//region SECTION: Public
    public function hasPassword(): bool
    {
        return $this->password !== '';
    }

    public function hasUsername(): bool
    {
        return $this->username !== '';
    }

    public function hasEmail(): bool
    {
        return $this->email !== '';
    }

    public function isActive(): bool
    {
        return $this->active == ActiveModel::ACTIVE;
    }

    public function hasRoles(): bool
    {
        return count($this->roles);
    }

    /**
     * @return bool
     */
    public function hasSurname(): bool
    {
        return $this->surname !== '';
    }

    /**
     * @return bool
     */
    public function hasPatronymic(): bool
    {
        return $this->patronymic !== '';
    }

    /**
     * @return bool
     */
    public function hasExpiredAt(): bool
    {
        return $this->expiredAt !== null;
    }

    /**
     * @return bool
     */
    public function emptyExpiredAt(): bool
    {
        return $this->expiredAt === '';
    }
//endregion Public

//region SECTION: Private
    /**
     * @param string $expiredAt
     */
    private function setExpiredAt(string $expiredAt): void
    {
        $this->expiredAt = $expiredAt;
    }

    /**
     * @param string $username
     *
     * @return void
     */
    private function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @param string $password
     *
     * @return void
     */
    private function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @param string $email
     *
     * @return void
     */
    private function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param array $roles
     *
     * @return void
     */
    private function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @param string $surname
     */
    private function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @param string $patronymic
     */
    private function setPatronymic(string $patronymic): void
    {
        $this->patronymic = $patronymic;
    }
//endregion Private

//region SECTION: Dto
    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $active     = $request->get(ModelInterface::ACTIVE);
            $id         = $request->get(ModelInterface::ID);
            $email      = $request->get(ModelInterface::EMAIL);
            $username   = $request->get(ModelInterface::USERNAME);
            $password   = $request->get(ModelInterface::PASSWORD);
            $roles      = $request->get(ModelInterface::ROLES, []);
            $name       = $request->get(ModelInterface::NAME);
            $surname    = $request->get(ModelInterface::SURNAME);
            $patronymic = $request->get(ModelInterface::PATRONYMIC);
            $expiredAt  = $request->get(ModelInterface::EXPIRED_AT);

            if ($active) {
                $this->setActive($active);
            }
            if ($id) {
                $this->setId(trim($id));
            }
            if ($name) {
                $this->setName(trim($name));
            }
            if ($surname) {
                $this->setSurname(trim($surname));
            }
            if ($patronymic) {
                $this->setPatronymic(trim($patronymic));
            }
            if ($email) {
                $this->setEmail(trim($email));
            }
            if ($password) {
                $this->setPassword(trim($password));
            }
            if ($username) {
                $this->setUserName(trim($username));
            }
            if ($roles) {
                $this->setRoles($roles);
            }
            if ($expiredAt !== null) {
                $this->setExpiredAt(trim($expiredAt));
            }
        }

        return $this;
    }
//endregion SECTION: Dto

//region SECTION: Getters/Setters
    /**
     * @return string
     */
    public function getExpiredAt(): string
    {
        return $this->expiredAt;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getPatronymic(): string
    {
        return $this->patronymic;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
//endregion Getters/Setters
}