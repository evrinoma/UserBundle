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

namespace Evrinoma\UserBundle\Mediator;

use Doctrine\ORM\QueryBuilder;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Evrinoma\UserBundle\Repository\AliasInterface;
use Evrinoma\UtilsBundle\Mediator\AbstractQueryMediator;

class QueryMediator extends AbstractQueryMediator implements QueryMediatorInterface
{
    protected static string $alias = AliasInterface::USER;

    /**
     * @param DtoInterface $dto
     * @param QueryBuilder $builder
     *
     * @return mixed
     */
    public function createQuery(DtoInterface $dto, QueryBuilder $builder): void
    {
        $alias = $this->alias();

        /** @var $dto UserApiDtoInterface */
        if ($dto->hasId()) {
            $builder
                ->andWhere($alias.'.id = :id')
                ->setParameter('id', $dto->getId());
        }

        if ($dto->hasUsername()) {
            $builder
                ->andWhere($alias.'.username = :username')
                ->setParameter('username', $dto->getUsername());
        }

        if ($dto->hasEmail()) {
            $builder
                ->andWhere($alias.'.email like :email')
                ->setParameter('email', '%'.$dto->getEmail().'%');
        }

        if ($dto->hasActive()) {
            $builder
                ->andWhere($alias.'.active = :active')
                ->setParameter('active', $dto->getActive());
        }
    }
}
