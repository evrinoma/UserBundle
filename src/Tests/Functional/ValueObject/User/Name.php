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

namespace Evrinoma\UserBundle\Tests\Functional\ValueObject\User;

use Evrinoma\TestUtilsBundle\ValueObject\Common\AbstractName;

class Name extends AbstractName
{
    protected static string $value   = 'Ivan';
    protected static string $default = 'Ivan';

    public static function value(): string
    {
        return 'Test '.parent::value();
    }

    public static function valueOwn(): string
    {
        return static::$value.'00';
    }
}
