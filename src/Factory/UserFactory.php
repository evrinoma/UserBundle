<?php

namespace Evrinoma\UserBundle\Factory;


use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Evrinoma\UserBundle\Entity\User\BaseUser;
use Evrinoma\UserBundle\Model\User\UserInterface;

class UserFactory implements UserFactoryInterface
{

    private static string $entityClass = BaseUser::class;


    public function __construct(string $entityClass)
    {
        self::$entityClass = $entityClass;
    }


    /**
     * @param UserApiDtoInterface $dto
     *
     * @return UserInterface
     */
    public function create(UserApiDtoInterface $dto): UserInterface
    {
        /** @var BaseUser $user */

        return new self::$entityClass;
    }

}