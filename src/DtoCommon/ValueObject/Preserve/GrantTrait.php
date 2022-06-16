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

trait GrantTrait
{
    /**
     * @return DtoInterface
     */
    public function setGrant(): DtoInterface
    {
        return parent::setGrant();
    }

    /**
     * @return DtoInterface
     */
    public function resetGrant(): DtoInterface
    {
        return parent::resetGrant();
    }
}
