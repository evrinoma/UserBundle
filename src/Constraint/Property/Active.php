<?php


namespace Evrinoma\UserBundle\Constraint\Property;

use Evrinoma\UtilsBundle\Constraint\Property\ActiveTrait;
use Evrinoma\UtilsBundle\Constraint\Property\ConstraintInterface;

class Active implements ConstraintInterface
{

    use ActiveTrait;
}