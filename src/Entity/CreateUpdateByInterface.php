<?php


namespace Evrinoma\UserBundle\Entity;

use Evrinoma\UserBundle\Model\User\UserInterface;

interface CreateUpdateByInterface
{
    public function getCreatedBy():UserInterface;

    public function getUpdatedBy():?UserInterface;
}