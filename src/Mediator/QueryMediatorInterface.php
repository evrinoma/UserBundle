<?php

namespace Evrinoma\UserBundle\Mediator;

use Doctrine\ORM\QueryBuilder;
use Evrinoma\UserBundle\Dto\UserApiDtoInterface;

interface QueryMediatorInterface
{
    /**
     * @return string
     */
    public function alias(): string;

    /**
     * @param UserApiDtoInterface $dto
     * @param QueryBuilder        $builder
     *
     * @return mixed
     */
    public function createQuery(UserApiDtoInterface $dto, QueryBuilder $builder): void;


    /**
     * @param UserApiDtoInterface $dto
     * @param QueryBuilder        $builder
     *
     * @return array
     */
    public function getResult(UserApiDtoInterface $dto, QueryBuilder $builder): array;
}