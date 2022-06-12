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

use Evrinoma\UserBundle\Model\User\UserInterface;

interface CreateUpdateByInterface
{
    /**
     * @return UserInterface
     */
    public function getCreatedBy(): UserInterface;

    /**
     * @return UserInterface|null
     */
    public function getUpdatedBy(): ?UserInterface;

    /**
     * @param $createdBy
     *
     * @return $this
     */
    public function setCreatedBy($createdBy): self;

    /**
     * @param $updatedBy
     *
     * @return $this
     */
    public function setUpdatedBy($updatedBy): self;
}
