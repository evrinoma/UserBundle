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

namespace Evrinoma\UserBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UserBundle\Model\User\AbstractUser;

/**
 * @ORM\Table(name="e_user")
 * @ORM\Entity
 */
class BaseUser extends AbstractUser
{
}
