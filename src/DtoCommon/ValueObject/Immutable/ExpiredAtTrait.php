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

trait ExpiredAtTrait
{
    private ?string $expiredAt = null;

    /**
     * @return bool
     */
    public function hasExpiredAt(): bool
    {
        return null !== $this->expiredAt;
    }

    /**
     * @return bool
     */
    public function emptyExpiredAt(): bool
    {
        return '' === $this->expiredAt;
    }

    /**
     * @return string
     */
    public function getExpiredAt(): string
    {
        return $this->expiredAt;
    }
}
