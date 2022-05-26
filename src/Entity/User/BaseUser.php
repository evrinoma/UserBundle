<?php

namespace Evrinoma\UserBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UserBundle\Model\User\AbstractUser;

/**
 * @ORM\Table(name="e_user")
 * @ORM\Entity()
 */
class BaseUser extends AbstractUser
{
}