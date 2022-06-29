<?php

declare(strict_types=1);

/*
 * This file is part of the package.
 *
 * (c) Nikolay Nikolaev <evrinoma@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evrinoma\UserBundle\PreValidator;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UserBundle\Dto\UserApiDtoInterface;
use Evrinoma\UserBundle\Exception\UserInvalidException;
use Evrinoma\UserBundle\PreChecker\PasswordPreCheckerInterface;
use Evrinoma\UtilsBundle\PreValidator\AbstractPreValidator;

class DtoPreValidator extends AbstractPreValidator implements DtoPreValidatorInterface
{
    private PasswordPreCheckerInterface $passwordPreChecker;

    public function __construct(PasswordPreCheckerInterface $postPreChecker)
    {
        $this->passwordPreChecker = $postPreChecker;
    }

    public function onPost(DtoInterface $dto): void
    {
        $this->checkUserName($dto);

        /** @var UserApiDtoInterface $dto */
        if (!$dto->hasPassword()) {
            throw new UserInvalidException('The Dto has\'t Password');
        }

        try {
            $this->passwordPreChecker->check($dto);
        } catch (\Exception $e) {
            throw new UserInvalidException($e->getMessage());
        }
    }

    public function onPut(DtoInterface $dto): void
    {
        $this->checkId($dto);

        $this->checkUserName($dto);
        /** @var UserApiDtoInterface $dto */
        if ($dto->hasPassword()) {
            try {
                $this->passwordPreChecker->check($dto);
            } catch (\Exception $e) {
                throw new UserInvalidException($e->getMessage());
            }
        }
    }

    public function onDelete(DtoInterface $dto): void
    {
        $this->checkId($dto);
    }

    private function checkId(DtoInterface $dto): void
    {
        /** @var UserApiDtoInterface $dto */
        if (!$dto->hasId()) {
            throw new UserInvalidException('The Dto has\'t ID or class invalid');
        }
    }

    private function checkUserName(DtoInterface $dto): void
    {
        /** @var UserApiDtoInterface $dto */
        if (!$dto->hasUsername()) {
            throw new UserInvalidException('The Dto has\'t UserName');
        }

        $username = $dto->getUsername();
        $isValid = false;

        if (preg_match('/^(?=.{4})(?!.{21})[\w.-]*[a-z][\w]*$/i', $username)) {
            $isValid = true;
        }
        if (preg_match('/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/i', $username)) {
            $isValid = true;
        }
        if (!$isValid) {
            throw new UserInvalidException('The Dto username must contain symbols, digit and special characters [._-] or username should have email format');
        }
    }
}
