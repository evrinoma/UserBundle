<?php

namespace Evrinoma\UserBundle\DependencyInjection\Compiler\Constraint\Property;

use Evrinoma\UserBundle\Validator\UserValidator;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractConstraint;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class UserPass extends AbstractConstraint implements CompilerPassInterface
{
//region SECTION: Fields
    public const USER_CONSTRAINT = 'evrinoma.user.constraint.property';

    protected static string $alias      = self::USER_CONSTRAINT;
    protected static string $class      = UserValidator::class;
    protected static string $methodCall = 'addPropertyConstraint';
//endregion Fields
}