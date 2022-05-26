<?php


namespace Evrinoma\UserBundle\Constraint\Property;

use Evrinoma\UtilsBundle\Constraint\Property\ConstraintInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

final class Password implements ConstraintInterface
{
//region SECTION: Getters/Setters
    public function getConstraints(): array
    {
        return [
            new UserPassword(),
        ];
    }

    public function getPropertyName(): string
    {
        return 'password';
    }
//endregion Getters/Setters
}