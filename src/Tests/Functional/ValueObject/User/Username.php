<?php

namespace Evrinoma\UserBundle\Tests\Functional\ValueObject\User;

use Evrinoma\TestUtilsBundle\ValueObject\AbstractValueObject;
use Evrinoma\TestUtilsBundle\ValueObject\ValueObjectTest;

class Username extends AbstractValueObject implements ValueObjectTest
{
//region SECTION: Fields
    protected static string $value = "test1";
    protected static string $wrong = "test";

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
//endregion Public
}