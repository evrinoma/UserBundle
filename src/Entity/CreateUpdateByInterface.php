<?php


namespace Evrinoma\UserBundle\Entity;

interface CreateUpdateByInterface
{
    public function getCreatedBy():User;

    public function getUpdatedBy():?User;
}