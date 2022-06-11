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

namespace Evrinoma\UserBundle\Factory;

use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Evrinoma\UserBundle\Entity\User\BaseUser;
use Evrinoma\UserBundle\Model\User\UserInterface;

class UserFactory implements UserFactoryInterface
{
    private static string $entityClass = BaseUser::class;

    public function __construct(string $entityClass)
    {
        self::$entityClass = $entityClass;
    }

    /**
     * @param UserApiDtoInterface $dto
     *
     * @return UserInterface
     */
    public function create(UserApiDtoInterface $dto): UserInterface
    {
        /* @var BaseUser $user */

        return new self::$entityClass();
    }
}
