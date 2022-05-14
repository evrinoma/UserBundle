<?php

namespace Evrinoma\UserBundle\Mediator;

use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Doctrine\Common\Collections\Criteria;

interface QueryMediatorInterface
{
//region SECTION: Public
    /**
     * @param UserApiDtoInterface $dto
     * @param Criteria            $criteria
     */
    public function createQuery(UserApiDtoInterface $dto, Criteria $criteria): void;
//endregion Public
}