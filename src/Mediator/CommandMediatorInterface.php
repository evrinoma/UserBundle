<?php

namespace Evrinoma\UserBundle\Mediator;

use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Evrinoma\UserBundle\Exception\UserCannotBeCreatedException;
use Evrinoma\UserBundle\Exception\UserCannotBeRemovedException;
use Evrinoma\UserBundle\Exception\UserCannotBeSavedException;
use Evrinoma\UserBundle\Model\User\UserInterface;

interface CommandMediatorInterface
{

    /**
     * @param UserApiDtoInterface $dto
     * @param UserInterface       $entity
     *
     * @return UserInterface
     * @throws UserCannotBeSavedException
     */
    public function onUpdate(UserApiDtoInterface $dto, UserInterface $entity): UserInterface;

    /**
     * @param UserApiDtoInterface $dto
     * @param UserInterface       $entity
     *
     * @throws UserCannotBeRemovedException
     */
    public function onDelete(UserApiDtoInterface $dto, UserInterface $entity): void;

    /**
     * @param UserApiDtoInterface $dto
     * @param UserInterface       $entity
     *
     * @return UserInterface
     * @throws UserCannotBeSavedException
     * @throws UserCannotBeCreatedException
     */
    public function onCreate(UserApiDtoInterface $dto, UserInterface $entity): UserInterface;

}