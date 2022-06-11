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

use Doctrine\ORM\Exception\ORMException;
use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Evrinoma\UserBundle\Exception\UserNotFoundException;
use Evrinoma\UserBundle\Exception\UserProxyException;
use Symfony\Component\Security\Core\User\UserInterface;

interface UserQueryRepositoryInterface
{
    /**
     * @param UserApiDtoInterface $dto
     *
     * @return array
     *
     * @throws UserNotFoundException
     */
    public function findByCriteria(UserApiDtoInterface $dto): array;

    /**
     * @param      $id
     * @param null $lockMode
     * @param null $lockVersion
     *
     * @return UserInterface
     *
     * @throws UserNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null): UserInterface;

    /**
     * @param string $id
     *
     * @return UserInterface
     *
     * @throws UserProxyException
     * @throws ORMException
     */
    public function proxy(string $id): UserInterface;
}
