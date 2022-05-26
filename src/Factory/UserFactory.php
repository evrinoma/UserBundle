<?php

namespace Evrinoma\UserBundle\Factory;


use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Evrinoma\UserBundle\Entity\User\BaseUser;
use Evrinoma\UserBundle\Exception\UserCannotBeCreatedException;
use Evrinoma\UserBundle\Exception\UserInvalidException;
use Evrinoma\UserBundle\Model\User\UserInterface;
use Evrinoma\UserBundle\Voter\RoleInterface;

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
            ->setName($dto->getName())
            ->setSurname($dto->getSurname())
            ->setPatronymic($dto->getPatronymic())
            ->setActiveToActive();

        if ($dto->hasExpiredAt()) {
            if ($dto->emptyExpiredAt()) {
                $user->setExpiredAt(null);
            } else {
                $user->setExpiredAt(new \DateTimeImmutable($dto->getExpiredAt()));
            }
        } else {
            throw new UserInvalidException();
        }

        return $user;
    }
//endregion Public
}