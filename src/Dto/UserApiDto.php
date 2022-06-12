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
    use ActiveTrait;
    use EmailTrait;
    use ExpiredAtTrait;
    use IdTrait;
    use NameTrait;
    use PasswordTrait;
    use PatronymicTrait;
    use RolesTrait;
    use SurnameTrait;
    use UsernameTrait;

    public function isActive(): bool
    {
        return ActiveModel::ACTIVE == $this->active;
    }

    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $active = $request->get(UserApiDtoInterface::ACTIVE);
            $id = $request->get(UserApiDtoInterface::ID);
            $email = $request->get(UserApiDtoInterface::EMAIL);
            $username = $request->get(UserApiDtoInterface::USERNAME);
            $password = $request->get(UserApiDtoInterface::PASSWORD);
            $granRoles = $request->get(UserApiDtoInterface::GRANT_ROLES);
            $roles = $request->get(UserApiDtoInterface::ROLES, []);
            $name = $request->get(UserApiDtoInterface::NAME);
            $surname = $request->get(UserApiDtoInterface::SURNAME);
            $patronymic = $request->get(UserApiDtoInterface::PATRONYMIC);
            $expiredAt = $request->get(UserApiDtoInterface::EXPIRED_AT);

            if ($active) {
                $this->setActive($active);
            }
            if ($id) {
                $this->setId((int) $id);
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
            if ($granRoles) {
                if ('true' === $granRoles) {
                    $this->setGrant();
                } else {
                    $this->resetGrant();
                }
            }
            if (null !== $expiredAt) {
                $this->setExpiredAt(trim($expiredAt));
            }
        }

        return $this;
    }
}
