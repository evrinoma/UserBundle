<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Preserve;

use Evrinoma\DtoBundle\Dto\DtoInterface;

trait EmailTrait
{

    /**
     * @param string $email
     *
     * @return DtoInterface
     */
    public function setEmail(string $email): DtoInterface
    {
        return parent::setEmail($email);
    }

}