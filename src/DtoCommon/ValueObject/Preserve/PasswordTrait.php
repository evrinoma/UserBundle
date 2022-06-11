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

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Preserve;

use Evrinoma\DtoBundle\Dto\DtoInterface;

trait PasswordTrait
{
    /**
     * @param string $password
     *
     * @return DtoInterface
     */
    public function setPassword(string $password): DtoInterface
    {
        return parent::setPassword($password);
    }
}
