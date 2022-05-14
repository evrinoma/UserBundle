<?php

namespace Evrinoma\UserBundle\Repository;

use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Evrinoma\UserBundle\Exception\UserCannotBeSavedException;
use Evrinoma\UserBundle\Exception\UserNotFoundException;
use Evrinoma\UserBundle\Exception\UserProxyException;
use Evrinoma\UserBundle\Mediator\QueryMediatorInterface;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;


class UserRepository implements UserRepositoryInterface
{
//region SECTION: Fields
    private EntityManagerInterface $entityManager;
    private QueryMediatorInterface $mediator;
    private UserManagerInterface   $userManager;
//endregion Fields

//region SECTION: Constructor
    /**
     * @param UserManagerInterface $userManager
     */
    public function __construct(EntityManagerInterface $entityManager, QueryMediatorInterface $mediator, UserManagerInterface $userManager)
    {
        $this->entityManager = $entityManager;
        $this->userManager   = $userManager;
        $this->mediator      = $mediator;
    }

//endregion Constructor

//region SECTION: Protected
//endregion Protected

//region SECTION: Public
    /**
     * @param UserInterface $user
     *
     * @return bool
     * @throws UserCannotBeSavedException
     * @throws ORMException
     */
    public function save(UserInterface $user): bool
    {
        try {
            $this->getEntityManager()->persist($user);
        } catch (ORMInvalidArgumentException $e) {
            throw new UserCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    /**
     * @param UserInterface $user
     *
     * @return bool
     */
    public function remove(UserInterface $user): bool
    {
        return true;
    }

    /**
     * @param string $id
     *
     * @return UserInterface
     * @throws UserProxyException
     * @throws ORMException
     */
    public function proxy(string $id): UserInterface
    {
        $em = $this->getEntityManager();

        $user = $em->getReference($this->getUserManager()->getClass(), $id);

        if (!$em->contains($user)) {
            throw new UserProxyException("Proxy doesn't exist with $id");
        }

        return $user;
    }
//endregion Public

//region SECTION: Private
    private function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    private function getUserManager(): UserManagerInterface
    {
        return $this->userManager;
    }
//endregion Private

//region SECTION: Find Filters Repository
    /**
     * @param UserApiDtoInterface $dto
     *
     * @return array
     * @throws UserNotFoundException
     */
    public function findByCriteria(UserApiDtoInterface $dto): array
    {
        $criteria = Criteria::create();

        $this->mediator->createQuery($dto, $criteria);

        $users = $this->getEntityManager()->getRepository($this->getUserManager()->getClass())->matching($criteria)->toArray();

        if (count($users) === 0) {
            throw new UserNotFoundException("Cannot find users by findByCriteria");
        }

        return $users;
    }

    /**
     * @param      $id
     * @param null $lockMode
     * @param null $lockVersion
     *
     * @return mixed
     * @throws UserNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null): UserInterface
    {
        /** @var UserInterface $user */
        $user = $this->getEntityManager()->getRepository($this->getUserManager()->getClass())->find($id);

        if ($user === null) {
            throw new UserNotFoundException("Cannot find user with id $id");
        }

        return $user;
    }
//endregion Find Filters Repository
}