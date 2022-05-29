<?php

namespace Evrinoma\UserBundle\PreValidator;

use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Evrinoma\UserBundle\Exception\UserInvalidException;

interface DtoPreValidatorInterface
{
    /**
     * @param UserApiDtoInterface $dto
     *
     * @throws UserInvalidException
     */
    public function onPost(UserApiDtoInterface $dto): void;

    /**
     * @param UserApiDtoInterface $dto
     *
     * @throws UserInvalidException
     */
    public function onPut(UserApiDtoInterface $dto): void;

    /**
     * @param UserApiDtoInterface $dto
     *
     * @throws UserInvalidException
     */
    public function onDelete(UserApiDtoInterface $dto): void;
}