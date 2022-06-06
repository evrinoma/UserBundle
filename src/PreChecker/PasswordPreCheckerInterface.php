<?php

namespace Evrinoma\UserBundle\PreChecker;

use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Evrinoma\UserBundle\Exception\UserInvalidException;

interface PasswordPreCheckerInterface
{
    /**
     * @param UserApiDtoInterface $dto
     *
     * @throws UserInvalidException
     */
    public function check(UserApiDtoInterface $dto): bool;
}