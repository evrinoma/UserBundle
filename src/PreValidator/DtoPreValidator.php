<?php

namespace Evrinoma\UserBundle\PreValidator;

use Evrinoma\DtoBundle\Dto\DtoInterface;

use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Evrinoma\UserBundle\Exception\UserInvalidException;
use Evrinoma\UtilsBundle\PreValidator\AbstractPreValidator;

class DtoPreValidator extends AbstractPreValidator implements DtoPreValidatorInterface
{

//region SECTION: Public
    public function onPost(DtoInterface $dto): void
    {
        /** @var UserApiDtoInterface $dto */
        if (!$dto->hasPassword()) {
            throw new UserInvalidException('The Dto has\'t Password');
        }
    }

    public function onPut(DtoInterface $dto): void
    {
        $this->check($dto);

        /** @var UserApiDtoInterface $dto */
        if (!$dto->hasUsername()) {
            throw new UserInvalidException('The Dto has\'t UserName');
        }
    }

    public function onDelete(DtoInterface $dto): void
    {
        $this->check($dto);
    }

//endregion Public

    private function check(DtoInterface $dto): void
    {
        /** @var UserApiDtoInterface $dto */
        if (!$dto->hasId()) {
            throw new UserInvalidException('The Dto has\'t ID or class invalid');
        }
    }
}