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
