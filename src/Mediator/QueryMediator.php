<?php

namespace Evrinoma\UserBundle\Mediator;

use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Doctrine\Common\Collections\Criteria;

class QueryMediator implements QueryMediatorInterface
{
//region SECTION: Public
    /**
     * @param UserApiDtoInterface $dto
     * @param Criteria            $criteria
     */
    public function createQuery(UserApiDtoInterface $dto, Criteria $criteria): void
    {
        if ($dto->hasId()) {
            $criteria->andWhere(Criteria::expr()->eq('id', $dto->getId()));
        }

        if ($dto->hasUsername()) {
            $criteria->andWhere(Criteria::expr()->contains('username', $dto->getUsername()));
        }

        if ($dto->hasEmail()) {
            $criteria->andWhere(Criteria::expr()->contains('email', $dto->getEmail()));
        }
    }
//endregion Public
}