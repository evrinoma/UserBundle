<?php

namespace Evrinoma\UserBundle\PreChecker;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UserBundle\Exception\UserInvalidException;
use Evrinoma\UtilsBundle\PreChecker\AbstractPreChecker;

class PostPreChecker extends AbstractPreChecker implements PostPreCheckerInterface
{
//region SECTION: Public
    public function check(DtoInterface $dto): bool
    {
        $password = $dto->getPassword();

        if (!preg_match('@[0-9]@', $password)) {
            throw new UserInvalidException('The Dto password must contain at least one digit');
        }
        if (!preg_match('@[A-Z]@', $password)) {
            throw new UserInvalidException('The Dto password must contain at least one upper case letter');
        }
        if (!preg_match('@[a-z]@', $password)) {
            throw new UserInvalidException('The Dto password must contain at least one lower case letter');
        }
        if (!preg_match('@[^\w]@', $password)) {
            throw new UserInvalidException('The Dto password must contain at least one special character');
        }

        return true;
    }
//endregion Public
}