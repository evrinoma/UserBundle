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

namespace Evrinoma\UserBundle\Manager;

use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Evrinoma\UserBundle\Exception\UserCannotBeCreatedException;
use Evrinoma\UserBundle\Exception\UserCannotBeRemovedException;
use Evrinoma\UserBundle\Exception\UserCannotBeSavedException;
use Evrinoma\UserBundle\Exception\UserInvalidException;
use Evrinoma\UserBundle\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

interface CommandManagerInterface
{
    /**
     * @param UserApiDtoInterface $dto
     *
     * @return UserInterface
     *
     * @throws UserInvalidException
     * @throws UserCannotBeCreatedException
     */
    public function post(UserApiDtoInterface $dto): UserInterface;

    /**
     * @param UserApiDtoInterface $dto
     *
     * @return UserInterface
     *
     * @throws UserInvalidException
     * @throws UserNotFoundException
     * @throws UserCannotBeSavedException
     */
    public function put(UserApiDtoInterface $dto): UserInterface;

    /**
     * @param UserApiDtoInterface $dto
     *
     * @throws UserCannotBeRemovedException
     * @throws UserNotFoundException
     */
    public function delete(UserApiDtoInterface $dto): void;
}
