<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable\EmailTrait as EmailImmutableTrait;

trait EmailTrait
{
    use EmailImmutableTrait;


    /**
     * @param string $email
     *
     * @return DtoInterface
     */
    protected function setEmail(string $email): DtoInterface
    {
        $this->email = $email;

        return $this;
    }

}