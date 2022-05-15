<?php

namespace Evrinoma\UserBundle\Mediator;


use App\Security\AccessControlSystem\AccessControl;
use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Evrinoma\UserBundle\Model\User\UserInterface;
use Evrinoma\UserBundle\Voter\RoleInterface;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\SecurityBundle\AccessControl\AccessControlInterface;
use FOS\UserBundle\Model\FosUserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
class CommandMediator implements CommandMediatorInterface
{

//region SECTION: Fields
    private UserManagerInterface $userManager;
    /**
     * @var AccessControlInterface|AccessControl
     */
    private AccessControlInterface $accessControl;
//endregion Fields

//region SECTION: Constructor
    public function __construct(UserManagerInterface $userManager, AccessControlInterface $accessControl)
    {
        $this->userManager   = $userManager;
        $this->accessControl = $accessControl;
    }
//endregion Constructor

//region SECTION: Public
    public function onUpdate(DtoInterface $dto, $entity): UserInterface
    {
        $this->accessControl->denyAccessUnlessGranted(RoleInterface::ROLE_USER_EDIT, $entity);

        /** @var UserInterface $entity */
        /** @var UserApiDtoInterface $dto */
//        $entity->setPlainPassword($dto->getPassword());
//        $this->userManager->updateCanonicalFields($entity);
//        $this->userManager->updatePassword($entity);
//
//        $entity->setEnabled($dto->isActive());
//
//        if ($dto->hasName() && $dto->hasSurname()) {
//            $entity->setName(trim($dto->getName()));
//            $entity->setSurname(trim($dto->getSurname()));
//        } else {
//            throw new UserCannotBeSavedException();
//        }
//
//        $entity->setPatronymic(trim($dto->getPatronymic()));
//
//        if ($dto->hasExpiredAt()) {
//            if ($dto->emptyExpiredAt()) {
//                $entity->setExpiredAt(null);
//            } else {
//                $entity->setExpiredAt(new \DateTimeImmutable($dto->getExpiredAt()));
//            }
//        }
//
//        if ($dto->hasRoles()) {
//            $rolesUnRevoke = $this->accessControl->revokePrivileges($entity->getRoles());
//            $rolesGrant    = $this->accessControl->grantPrivileges($dto->getRoles());
//
//            $entity->setRoles(array_merge($rolesGrant, $rolesUnRevoke));
//        }

        return $entity;
    }

    public function onDelete(DtoInterface $dto, $entity): void
    {
        $this->accessControl->denyAccessUnlessGranted(RoleInterface::ROLE_USER_EDIT, $entity);

        /** @var FosUserInterface $entity */
        $entity->setEnabled($dto->isActive());
    }

    public function onCreate(DtoInterface $dto, $entity): UserInterface
    {
        $this->accessControl->denyAccessUnlessGranted(RoleInterface::ROLE_USER_CREATE, $entity);

        return $entity;
    }
//endregion Public
}