<?php

namespace Evrinoma\UserBundle\Manager;

use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Evrinoma\UserBundle\Exception\UserNotFoundException;
use Evrinoma\UserBundle\Exception\UserProxyException;
use Symfony\Component\Security\Core\User\UserInterface;

interface QueryManagerInterface
{
    /**
     * @param UserApiDtoInterface $dto
     *
     * @return array
     * @throws UserNotFoundException
     */
    public function criteria(UserApiDtoInterface $dto): array;
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @param UserApiDtoInterface $dto
     *
     * @return UserInterface
     * @throws UserNotFoundException
     */
    public function get(UserApiDtoInterface $dto): UserInterface;
    /**
     * @param UserApiDtoInterface $dto
     *
     * @return UserInterface
     * @throws UserProxyException
     */
    public function proxy(UserApiDtoInterface $dto): UserInterface;
}