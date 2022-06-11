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

interface PatronymicInterface
{
    public const PATRONYMIC = 'patronymic';

    /**
     * @return bool
     */
    public function hasPatronymic(): bool;

    /**
     * @return string
     */
    public function getPatronymic(): string;
}
