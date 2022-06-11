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

namespace Evrinoma\UserBundle\PreValidator;

use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Evrinoma\UserBundle\Exception\UserInvalidException;

interface DtoPreValidatorInterface
{
    /**
     * @param UserApiDtoInterface $dto
     *
     * @throws UserInvalidException
     */
    public function onPost(UserApiDtoInterface $dto): void;

    /**
     * @param UserApiDtoInterface $dto
     *
     * @throws UserInvalidException
     */
    public function onPut(UserApiDtoInterface $dto): void;

    /**
     * @param UserApiDtoInterface $dto
     *
     * @throws UserInvalidException
     */
    public function onDelete(UserApiDtoInterface $dto): void;
}
