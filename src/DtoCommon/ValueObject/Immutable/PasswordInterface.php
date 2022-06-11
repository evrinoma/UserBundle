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

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

interface PasswordInterface
{
    public const PASSWORD = 'password';

    /**
     * @return bool
     */
    public function hasPassword(): bool;

    /**
     * @return string
     */
    public function getPassword(): string;
}
