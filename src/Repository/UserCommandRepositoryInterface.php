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

namespace Evrinoma\UserBundle\Repository;

use Evrinoma\UserBundle\Exception\UserCannotBeRemovedException;
use Evrinoma\UserBundle\Exception\UserCannotBeSavedException;
use Evrinoma\UserBundle\Model\User\UserInterface;

interface UserCommandRepositoryInterface
{
    /**
     * @param UserInterface $user
     *
     * @return bool
     *
     * @throws UserCannotBeSavedException
     */
    public function save(UserInterface $user): bool;

    /**
     * @param UserInterface $user
     *
     * @return bool
     *
     * @throws UserCannotBeRemovedException
     */
    public function remove(UserInterface $user): bool;
}
