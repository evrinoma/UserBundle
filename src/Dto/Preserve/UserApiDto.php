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

namespace Evrinoma\UserBundle\Dto\Preserve;


use Evrinoma\UserBundle\Dto\UserApiDto as BaseUserApiDto;

class UserApiDto extends BaseUserApiDto implements UserApiDtoInterface
{
    use UserApiDtoTrait;
}
