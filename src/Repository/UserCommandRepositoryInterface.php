<?php

namespace Evrinoma\UserBundle\Repository;

use Evrinoma\UserBundle\Exception\UserCannotBeRemovedException;
use Evrinoma\UserBundle\Exception\UserCannotBeSavedException;
use Symfony\Component\Security\Core\User\UserInterface;

interface UserCommandRepositoryInterface
{
    /**
     * @param UserInterface $user
     *
     * @return bool
     * @throws UserCannotBeSavedException
     */
    public function save(UserInterface $user): bool;

    /**
     * @param UserInterface $user
     *
     * @return bool
     * @throws UserCannotBeRemovedException
     */
    public function remove(UserInterface $user): bool;
}