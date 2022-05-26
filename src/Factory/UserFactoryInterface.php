<?php

namespace Evrinoma\UserBundle\Factory;

use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Evrinoma\UserBundle\Model\User\UserInterface;

interface UserFactoryInterface
{
    /**
     * @param UserApiDtoInterface $dto
     *
     * @return UserInterface
     */
    public function create(UserApiDtoInterface $dto): UserInterface;
}