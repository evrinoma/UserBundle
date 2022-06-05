<?php

namespace Evrinoma\UserBundle\Command\Dto\Preserve;

use Evrinoma\UserBundle\Dto\Preserve\UserApiDtoTrait;
use Evrinoma\UserBundle\Dto\UserApiDto;

final class PreserveUserApiDto extends UserApiDto implements PreserveUserApiDtoInterface
{
    use UserApiDtoTrait;
}
