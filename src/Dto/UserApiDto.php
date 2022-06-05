<?php

namespace Evrinoma\UserBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\ActiveTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\NameTrait;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable\EmailTrait;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable\ExpiredAtTrait;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable\PasswordTrait;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable\PatronymicTrait;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable\RolesTrait;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable\SurnameTrait;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable\UsernameTrait;
use Evrinoma\UtilsBundle\Model\ActiveModel;
use Symfony\Component\HttpFoundation\Request;

class UserApiDto extends AbstractDto implements UserApiDtoInterface
{
    use ActiveTrait, IdTrait, NameTrait, PasswordTrait, UsernameTrait, EmailTrait, RolesTrait, SurnameTrait, PatronymicTrait, ExpiredAtTrait;

//region SECTION: Public
    public function isActive(): bool
    {
        return $this->active == ActiveModel::ACTIVE;
    }
//endregion Public

//region SECTION: Dto
    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $active     = $request->get(UserApiDtoInterface::ACTIVE);
            $id         = $request->get(UserApiDtoInterface::ID);
            $email      = $request->get(UserApiDtoInterface::EMAIL);
            $username   = $request->get(UserApiDtoInterface::USERNAME);
            $password   = $request->get(UserApiDtoInterface::PASSWORD);
            $roles      = $request->get(UserApiDtoInterface::ROLES, []);
            $name       = $request->get(UserApiDtoInterface::NAME);
            $surname    = $request->get(UserApiDtoInterface::SURNAME);
            $patronymic = $request->get(UserApiDtoInterface::PATRONYMIC);
            $expiredAt  = $request->get(UserApiDtoInterface::EXPIRED_AT);

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
}