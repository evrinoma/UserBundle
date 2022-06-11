<?php

declare(strict_types=1);

/*
 * This file is part of the package.
 *
 * (c) Nikolay Nikolaev <evrinoma@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evrinoma\UserBundle\PreChecker;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UserBundle\Exception\UserInvalidException;
use Evrinoma\UtilsBundle\PreChecker\AbstractPreChecker;

class PasswordPreChecker extends AbstractPreChecker implements PasswordPreCheckerInterface
{
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
}
