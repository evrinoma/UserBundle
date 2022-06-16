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

interface GrantInterface
{
    public const GRANT_ROLES = 'grant';

    /**
     * @return bool
     */
    public function isGranted(): bool;

    /**
     * @return bool
     */
    public function hasGranted(): bool;
}
