<?php

namespace Evrinoma\UserBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;
use Doctrine\Persistence\ManagerRegistry;
use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Evrinoma\UserBundle\Exception\UserCannotBeSavedException;
use Evrinoma\UserBundle\Exception\UserNotFoundException;
use Evrinoma\UserBundle\Exception\UserProxyException;
use Evrinoma\UserBundle\Mediator\QueryMediatorInterface;
use Evrinoma\UserBundle\Model\User\UserInterface;


class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
//region SECTION: Fields
    private QueryMediatorInterface $mediator;
//endregion Fields

//region SECTION: Constructor
    /**
     * @param ManagerRegistry        $registry
     * @param string                 $entityClass
     * @param QueryMediatorInterface $mediator
     */
    public function __construct(ManagerRegistry $registry, string $entityClass, QueryMediatorInterface $mediator)
    {
        parent::__construct($registry, $entityClass);
        $this->mediator = $mediator;
    }

//endregion Constructor

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

        $user = $em->getReference($this->getEntityName(), $id);

        if (!$em->contains($user)) {
            throw new UserProxyException("Proxy doesn't exist with $id");
        }

        return $user;
    }
//endregion Public

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

        // $users = $this->getEntityManager()->getRepository($this->getUserManager()->getClass())->matching($criteria)->toArray();

        $users = null;

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
        /** @var UserInterface $fcr */
        $user = parent::find($id);

        if ($user === null) {
            throw new UserNotFoundException("Cannot find user with id $id");
        }

        return $user;
    }
//endregion Find Filters Repository
}