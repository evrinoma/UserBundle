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

namespace Evrinoma\UserBundle\Mediator;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UserBundle\Dto\Preserve\UserApiDtoInterface as PreserveUserApiDtoInterface;
use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Evrinoma\UserBundle\Exception\UserCannotBeCreatedException;
use Evrinoma\UserBundle\Exception\UserCannotBeSavedException;
use Evrinoma\UserBundle\Model\User\UserInterface;
use Evrinoma\UserBundle\Role\RoleMediatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CommandMediator implements CommandMediatorInterface
{
    /**
     * @var RoleMediatorInterface
     */
    private RoleMediatorInterface $roleMediator;
    /**
     * @var UserPasswordHasherInterface
     */
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher, RoleMediatorInterface $roleMediator)
    {
        $this->passwordHasher = $passwordHasher;
        $this->roleMediator = $roleMediator;
    }

    public function onUpdate(DtoInterface $dto, $entity): UserInterface
    {
        /* @var UserApiDtoInterface $dto */
        $entity
            ->setUsername($dto->getUsername())
            ->setEmail($dto->getEmail())
            ->setName($dto->getName())
            ->setSurname($dto->getSurname())
            ->setPatronymic($dto->getPatronymic())
            ->setActive($dto->getActive());

        if ($dto->hasExpiredAt()) {
            if ($dto->emptyExpiredAt()) {
                $entity->setExpiredAt(null);
            } else {
                $entity->setExpiredAt(new \DateTimeImmutable($dto->getExpiredAt()));
            }
        } else {
            throw new UserCannotBeSavedException();
        }

        if ($dto->hasRoles()) {
            if ($dto instanceof PreserveUserApiDtoInterface) {
                if ($dto->isGranted()) {
                    foreach ($dto->getRoles() as $role) {
                        $entity->addRole($role);
                    }
                } else {
                    foreach ($dto->getRoles() as $role) {
                        $entity->rmRole($role);
                    }
                }
            } else {
                $rolesUnRevoke = $this->roleMediator->revokePrivileges($entity->getRoles());
                $rolesGrant = $this->roleMediator->grantPrivileges($dto->getRoles());
                $entity->setRoles(array_unique(array_merge($rolesGrant, $rolesUnRevoke), \SORT_REGULAR));
            }
        }

        /** @var UserApiDtoInterface $dto */
        if ($dto->hasPassword()) {
            $entity->setPassword($this->passwordHasher->hashPassword($entity, $dto->getPassword()));
        }

        return $entity;
    }

    public function onDelete(DtoInterface $dto, $entity): void
    {
        $entity->setActiveToDelete();
    }

    public function onCreate(DtoInterface $dto, $entity): UserInterface
    {
        /* @var UserApiDtoInterface $dto */
        $entity
            ->setUsername($dto->getUsername())
            ->setSurname($dto->getUsername())
            ->setEmail($dto->getEmail())
            ->setName($dto->getName())
            ->setSurname($dto->getSurname())
            ->setPatronymic($dto->getPatronymic())
            ->setActiveToActive();

        if ($dto->hasExpiredAt()) {
            if ($dto->emptyExpiredAt()) {
                $entity->setExpiredAt(null);
            } else {
                $entity->setExpiredAt(new \DateTimeImmutable($dto->getExpiredAt()));
            }
        } else {
            throw new UserCannotBeCreatedException();
        }

        if ($dto->hasRoles()) {
            $rolesUnRevoke = $this->roleMediator->revokePrivileges($entity->getRoles());
            $rolesGrant = $this->roleMediator->grantPrivileges($dto->getRoles());

            $entity->setRoles(array_merge($rolesGrant, $rolesUnRevoke));
        }

        /** @var UserApiDtoInterface $dto */
        if ($dto->hasPassword()) {
            $entity->setPassword($this->passwordHasher->hashPassword($entity, $dto->getPassword()));
        }

        return $entity;
    }
}
