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
use Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable\SurnameTrait as SurnameImmutableTrait;

trait SurnameTrait
{
    use SurnameImmutableTrait;

    /**
     * @param string $surname
     *
     * @return DtoInterface
     */
    protected function setSurname(string $surname): DtoInterface
    {
        $this->surname = trim($surname);

        return $this;
    }
}
