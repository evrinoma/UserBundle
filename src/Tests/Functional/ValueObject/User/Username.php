<?php

namespace Evrinoma\UserBundle\Tests\Functional\ValueObject\User;

use Evrinoma\TestUtilsBundle\ValueObject\AbstractValueObject;
use Evrinoma\TestUtilsBundle\ValueObject\ValueObjectTest;

class Username extends AbstractValueObject implements ValueObjectTest
{
//region SECTION: Fields
    protected static string $value   = "test1";
    protected static string $wrong   = "test";
    protected static string $default = "IIvanov";
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