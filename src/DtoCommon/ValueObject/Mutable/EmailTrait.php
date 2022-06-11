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

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable\EmailTrait as EmailImmutableTrait;

trait EmailTrait
{
    use EmailImmutableTrait;

    /**
     * @param string $email
     *
     * @return DtoInterface
     */
    protected function setEmail(string $email): DtoInterface
    {
        $this->email = $email;

        return $this;
    }
}
