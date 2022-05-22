<?php

namespace Evrinoma\UserBundle\Factory;


use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Evrinoma\UserBundle\Entity\BaseUser;
use Evrinoma\UserBundle\Exception\UserCannotBeCreatedException;
use Evrinoma\UserBundle\Voter\RoleInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserFactory implements UserFactoryInterface
{
//region SECTION: Fields
    private static string $entityClass = BaseUser::class;
//endregion Fields

//region SECTION: Constructor
    public function __construct(string $entityClass)
    {
        self::$entityClass = $entityClass;
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
        /** @var BaseUser $user */
        $user = new self::$entityClass;

        $user
            ->setUsername($dto->getUsername())
            ->setSurname($dto->getUsername())
            ->setEmail($dto->getEmail())
            ->addRole(RoleInterface::ROLE_DEFAULT)
            ->setActiveToActive();

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