<?php

namespace Evrinoma\UserBundle\DtoCommon\ValueObject\Immutable;

interface ExpiredAtInterface
{

    public const EXPIRED_AT = 'expired_at';


    /**
     * @return bool
     */
    public function hasExpiredAt(): bool;

    /**
     * @return bool
     */
    public function emptyExpiredAt(): bool;


    /**
     * @return string
     */
    public function getExpiredAt(): string;


}