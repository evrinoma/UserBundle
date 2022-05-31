<?php

namespace Evrinoma\UserBundle\Tests\Functional\ValueObject\User;

use Evrinoma\TestUtilsBundle\ValueObject\AbstractValueObject;
use Evrinoma\TestUtilsBundle\ValueObject\ValueObjectTest;

class Password extends AbstractValueObject implements ValueObjectTest
{
//region SECTION: Fields
    protected static string $value   = "1Qw.";
    protected static string $wrong   = "password";
    protected static string $default = "2We,";
//endregion Fields
//region SECTION: Public
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
//endregion Public
}