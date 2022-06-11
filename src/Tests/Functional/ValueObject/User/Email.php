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

use Evrinoma\TestUtilsBundle\ValueObject\AbstractValueObject;
use Evrinoma\TestUtilsBundle\ValueObject\ValueObjectTest;

class Email extends AbstractValueObject implements ValueObjectTest
{
    protected static string $value   = 'test1@test.ru';
    protected static string $wrong   = 'test@test';
    protected static string $default = 'IIvanov@ite-ng.ru';

    public static function value(): string
    {
        return static::$value ?? 'test1@test.com';
    }

    public static function wrong(): string
    {
        return static::$wrong;
    }

    public static function default(): string
    {
        return static::$default ?? '';
    }
}
