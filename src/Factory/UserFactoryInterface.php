<?php

namespace Evrinoma\UserBundle\Factory;

use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Symfony\Component\Security\Core\User\UserInterface;

interface UserFactoryInterface
{
    /**
     * @param UserApiDtoInterface $dto
     *
     * @return UserInterface
     */
    public function create(UserApiDtoInterface $dto): UserInterface;
}