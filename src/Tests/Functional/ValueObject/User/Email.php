<?php

namespace Evrinoma\UserBundle\Tests\Functional\ValueObject\User;

use Evrinoma\TestUtilsBundle\ValueObject\AbstractValueObject;
use Evrinoma\TestUtilsBundle\ValueObject\ValueObjectTest;

class Email extends AbstractValueObject implements ValueObjectTest
{

    protected static string $value   = "test1@test.ru";
    protected static string $wrong   = "test@test";
    protected static string $default = "IIvanov@ite-ng.ru";


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