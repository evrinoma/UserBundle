<?php

namespace Evrinoma\UserBundle\Mediator;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Evrinoma\UserBundle\Exception\UserCannotBeCreatedException;
use Evrinoma\UserBundle\Exception\UserCannotBeSavedException;
use Evrinoma\UserBundle\Model\User\UserInterface;
use Evrinoma\UserBundle\Role\RoleMediatorInterface;
use Evrinoma\UserBundle\Voter\RoleInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CommandMediator implements CommandMediatorInterface
{
//region SECTION: Fields
    /**
     * @var RoleMediatorInterface
     */
    private RoleMediatorInterface $roleMediator;
    /**
     * @var UserPasswordHasherInterface
     */
    private UserPasswordHasherInterface $passwordHasher;
//endregion Fields

//region SECTION: Constructor
    public function __construct(UserPasswordHasherInterface $passwordHasher, RoleMediatorInterface $roleMediator)
    {
        $this->passwordHasher = $passwordHasher;
        $this->roleMediator   = $roleMediator;
    }
//endregion Constructor

//region SECTION: Public
    public function onUpdate(DtoInterface $dto, $entity): UserInterface
    {
        /** @var UserApiDtoInterface $dto */
        $entity
            ->setUsername($dto->getUsername())
            ->setSurname($dto->getUsername())
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
            $rolesUnRevoke = $this->roleMediator->revokePrivileges($entity->getRoles());
            $rolesGrant    = $this->roleMediator->grantPrivileges($dto->getRoles());

            $entity->setRoles(array_merge($rolesGrant, $rolesUnRevoke));
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
        /** @var UserApiDtoInterface $dto */
        $entity
            ->setUsername($dto->getUsername())
            ->setSurname($dto->getUsername())
            ->setEmail($dto->getEmail())
            ->setName($dto->getName())
            ->setSurname($dto->getSurname())
            ->setPatronymic($dto->getPatronymic())
            ->addRole(RoleInterface::ROLE_USER)
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

        /** @var UserApiDtoInterface $dto */
        if ($dto->hasPassword()) {
            $entity->setPassword($this->passwordHasher->hashPassword($entity, $dto->getPassword()));
        }

        return $entity;
    }
//endregion Public
}