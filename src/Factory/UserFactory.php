<?php

namespace Evrinoma\UserBundle\Factory;


use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Evrinoma\UserBundle\Entity\User;
use Evrinoma\UserBundle\Exception\UserCannotBeCreatedException;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserFactory implements UserFactoryInterface
{
//region SECTION: Fields
    private UserManagerInterface $userManager;
//endregion Fields

//region SECTION: Constructor
    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param UserApiDtoInterface $dto
     *
     * @return UserInterface
     */
    public function create(UserApiDtoInterface $dto): UserInterface
    {
        /** @var User $user */
        $user = $this->userManager->createUser();

        $user->setUsername($dto->getUsername());
        $user->setEmail($dto->getEmail());
        $user->setPlainPassword($dto->getPassword());
        $user->setEnabled(true);
        $user->setSuperAdmin(false);
        $this->userManager->updateCanonicalFields($user);
        $this->userManager->updatePassword($user);

        if ($dto->hasName() && $dto->hasSurname()) {
            $user->setName($dto->getName());
            $user->setSurname($dto->getSurname());
        } else {
            throw new UserCannotBeCreatedException();
        }

        $user->setPatronymic($dto->getPatronymic());

        if ($dto->hasExpiredAt()) {
            if ($dto->emptyExpiredAt()) {
                $user->setExpiredAt(null);
            } else {
                $user->setExpiredAt(new \DateTimeImmutable($dto->getExpiredAt()));
            }
        } else {
            throw new UserCannotBeCreatedException();
        }

        return $user;
    }
//endregion Public
}