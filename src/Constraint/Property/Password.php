<?php


namespace Evrinoma\UserBundle\Constraint\Property;

use Evrinoma\UtilsBundle\Constraint\Property\ConstraintInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

final class Password implements ConstraintInterface
{

    public function getConstraints(): array
    {
        return [
            new NotNull(),
            new NotBlank(),
        ];
    }

    public function getPropertyName(): string
    {
        return 'password';
    }

}