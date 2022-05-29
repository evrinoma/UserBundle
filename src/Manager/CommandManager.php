<?php

namespace Evrinoma\UserBundle\Manager;


use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Evrinoma\UserBundle\Exception\UserCannotBeCreatedException;
use Evrinoma\UserBundle\Exception\UserCannotBeRemovedException;
use Evrinoma\UserBundle\Exception\UserInvalidException;
use Evrinoma\UserBundle\Exception\UserNotFoundException;
use Evrinoma\UserBundle\Factory\UserFactoryInterface;
use Evrinoma\UserBundle\Mediator\CommandMediatorInterface;
use Evrinoma\UserBundle\Repository\UserCommandRepositoryInterface;
use Evrinoma\UtilsBundle\Rest\RestInterface;
use Evrinoma\UtilsBundle\Rest\RestTrait;
use Evrinoma\UtilsBundle\Validator\ValidatorInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class CommandManager implements CommandManagerInterface, RestInterface
{
    use RestTrait;

//region SECTION: Fields
    private UserCommandRepositoryInterface $repository;
    private ValidatorInterface             $validator;
    private UserFactoryInterface           $factory;
    private CommandMediatorInterface       $mediator;
//endregion Fields

//region SECTION: Constructor
    public function __construct(ValidatorInterface $validator, UserCommandRepositoryInterface $repository, UserFactoryInterface $factory, CommandMediatorInterface $mediator)
    {
        $this->validator  = $validator;
        $this->repository = $repository;
        $this->factory    = $factory;
        $this->mediator   = $mediator;
    }
//endregion Constructor

//region SECTION: Public
    /**
     * @param UserApiDtoInterface $dto
     *
     * @return UserInterface
     * @throws UserInvalidException
     * @throws UserCannotBeCreatedException
     */
    public function post(UserApiDtoInterface $dto): UserInterface
    {
        $user = $this->factory->create($dto);

        $this->mediator->onCreate($dto, $user);

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {

            $errorsString = (string)$errors;

            throw new UserInvalidException($errorsString);
        }

        $this->repository->save($user);

        return $user;
    }

    /**
     * @param UserApiDtoInterface $dto
     *
     * @return UserInterface
     * @throws UserInvalidException
     * @throws UserNotFoundException
     */
    public function put(UserApiDtoInterface $dto): UserInterface
    {
        try {
            $user = $this->repository->find($dto->getId());
        } catch (UserNotFoundException $e) {
            throw $e;
        }

        $this->mediator->onUpdate($dto, $user);

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {

            $errorsString = (string)$errors;

            throw new UserInvalidException($errorsString);
        }

        $this->repository->save($user);

        return $user;
    }

    /**
     * @param UserApiDtoInterface $dto
     *
     * @throws UserCannotBeRemovedException
     * @throws UserNotFoundException
     */
    public function delete(UserApiDtoInterface $dto): void
    {
        try {
            $user = $this->repository->find($dto->getId());
        } catch (UserNotFoundException $e) {
            throw $e;
        }

        $this->mediator->onDelete($dto, $user);

        try {
            $this->repository->remove($user);
        } catch (UserCannotBeRemovedException $e) {
            throw $e;
        }
    }
//endregion Public

//region SECTION: Getters/Setters
    public function getRestStatus(): int
    {
        return $this->status;
    }
//endregion Getters/Setters
}