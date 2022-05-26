<?php

namespace Evrinoma\UserBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UserBundle\Model\User\AbstractUser;

/**
 * Class User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity()
 */
class BaseUser extends AbstractUser
{
}