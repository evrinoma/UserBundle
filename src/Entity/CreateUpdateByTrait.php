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

namespace Evrinoma\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UserBundle\Model\User\UserInterface;

trait CreateUpdateByTrait
{
    /**
     * @var UserInterface
     * @ORM\ManyToOne(targetEntity="Evrinoma\UserBundle\Model\User\UserInterface")
     */
    private UserInterface $createdBy;

    /**
     * @var UserInterface|null
     * @ORM\ManyToOne(targetEntity="Evrinoma\UserBundle\Model\User\UserInterface")
     */
    private ?UserInterface $updatedBy = null;

    /**
     * @return UserInterface
     */
    public function getCreatedBy(): UserInterface
    {
        return $this->createdBy;
    }

    /**
     * @return UserInterface
     */
    public function getUpdatedBy(): ?UserInterface
    {
        return $this->updatedBy;
    }

    /**
     * @param $createdBy
     *
     * @return $this
     */
    public function setCreatedBy($createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @param $updatedBy
     *
     * @return $this
     */
    public function setUpdatedBy($updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }
}
