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
use Evrinoma\UserBundle\Exception\UserNotFoundException;
use Evrinoma\UserBundle\Exception\UserProxyException;
use Evrinoma\UserBundle\Repository\UserQueryRepositoryInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;
use Symfony\Component\Security\Core\User\UserInterface;

final class QueryManager implements QueryManagerInterface, RestInterface
{
    use RestTrait;

    private UserQueryRepositoryInterface $repository;

    public function __construct(UserQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param UserApiDtoInterface $dto
     *
     * @return array
     *
     * @throws UserNotFoundException
     */
    public function criteria(UserApiDtoInterface $dto): array
    {
        try {
            $user = $this->repository->findByCriteria($dto);
        } catch (UserNotFoundException $e) {
            throw $e;
        }

        return $user;
    }

    /**
     * @param UserApiDtoInterface $dto
     *
     * @return UserInterface
     *
     * @throws UserProxyException
     */
    public function proxy(UserApiDtoInterface $dto): UserInterface
    {
        try {
            $user = $this->repository->proxy($dto->getId());
        } catch (UserProxyException $e) {
            throw $e;
        }

        return $user;
    }

    public function getRestStatus(): int
    {
        return $this->status;
    }

    /**
     * @param UserApiDtoInterface $dto
     *
     * @return UserInterface
     *
     * @throws UserNotFoundException
     */
    public function get(UserApiDtoInterface $dto): UserInterface
    {
        try {
            $user = $this->repository->find($dto->getId());
        } catch (UserNotFoundException $e) {
            throw $e;
        }

        return $user;
    }
}
