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

class Password extends AbstractValueObject implements ValueObjectTest
{
    protected static string $value   = '1Qw.';
    protected static string $wrong   = 'password';
    protected static string $default = '2We,';

    public static function value(): string
    {
        return static::$value ?? '';
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
