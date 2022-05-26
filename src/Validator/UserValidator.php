<?php


namespace Evrinoma\UserBundle\Validator;

use Evrinoma\UserBundle\Tests\Functional\Action\BaseUser;
use Evrinoma\UtilsBundle\Validator\AbstractValidator;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class UserValidator extends AbstractValidator
{
//region SECTION: Fields
    /**
     * @var string|null
     */
    protected static ?string $entityClass = BaseUser::class;
//endregion Fields

//region SECTION: Constructor
    /**
     * @param ValidatorInterface $validator
     * @param string             $entityClass
     */
    public function __construct(ValidatorInterface $validator, string $entityClass)
    {
        parent::__construct($validator, $entityClass);
    }
//endregion Constructor
}