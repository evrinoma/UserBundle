<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Preserve;

use Evrinoma\DtoBundle\Dto\DtoInterface;

trait EmailTrait
{
//region SECTION: Getters/Setters
    /**
     * @param string $email
     *
     * @return DtoInterface
     */
    public function setEmail(string $email): DtoInterface
    {
        return parent::setEmail($email);
    }
//endregion Getters/Setters
}