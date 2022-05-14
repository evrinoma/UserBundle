<?php

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

//region SECTION: Fields
    private UserQueryRepositoryInterface $repository;
//endregion Fields

//region SECTION: Constructor
    public function __construct(UserQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param UserApiDtoInterface $dto
     *
     * @return array
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
//endregion Public

//region SECTION: Getters/Setters
    public function getRestStatus(): int
    {
        return $this->status;
    }

    /**
     * @param UserApiDtoInterface $dto
     *
     * @return UserInterface
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
//endregion Getters/Setters
}