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
        $this->check($dto);

        /** @var UserApiDtoInterface $dto */
        if (!$dto->hasUsername()) {
            throw new UserInvalidException('The Dto has\'t UserName');
        }

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
        $this->check($dto);
    }

    private function check(DtoInterface $dto): void
    {
        /** @var UserApiDtoInterface $dto */
        if (!$dto->hasId()) {
            throw new UserInvalidException('The Dto has\'t ID or class invalid');
        }
    }
}
