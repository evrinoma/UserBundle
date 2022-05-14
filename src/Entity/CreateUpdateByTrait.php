<?php

namespace Evrinoma\UserBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

trait CreateUpdateByTrait
{
//region SECTION: Fields
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\User\Entity\User")
     */
    private $createdBy;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\User\Entity\User")
     */
    private $updatedBy;
//endregion Fields

//region SECTION: Getters/Setters
    /**
     * Returns createdBy.
     *
     * @return User
     */
    public function getCreatedBy():User
    {
        return $this->createdBy;
    }

    /**
     * Returns updatedBy.
     *
     * @return User
     */
    public function getUpdatedBy():?User
    {
        return $this->updatedBy;
    }

    /**
     * Sets createdBy.
     *
     * @param $createdBy
     *
     * @return $this
     */
    public function setCreatedBy($createdBy):self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Sets updatedBy.
     *
     * @param $updatedBy
     *
     * @return $this
     */
    public function setUpdatedBy($updatedBy):self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }
//endregion Getters/Setters
}