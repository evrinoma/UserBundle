<?php

namespace Evrinoma\UserBundle\Tests\Functional\ValueObject\User;


use Evrinoma\TestUtilsBundle\ValueObject\Common\AbstractName;

class Name extends AbstractName
{
//region SECTION: Fields
    protected static string $value   = "Ivan";
    protected static string $default = "Ivan";
//endregion Fields
//region SECTION: Public
    public static function value(): string
    {
        return "Test ".parent::value();
    }

    public static function valueOwn(): string
    {
        return static::$value.'00';
    }
//endregion Public
}