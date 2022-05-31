<?php

namespace Evrinoma\UserBundle\Tests\Functional\ValueObject\User;

use Evrinoma\TestUtilsBundle\ValueObject\Common\AbstractActive;
use Evrinoma\UtilsBundle\Model\ActiveModel;

class Active extends AbstractActive
{
    protected static string $default = ActiveModel::MODERATED;
}