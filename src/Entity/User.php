<?php

namespace Evrinoma\UserBundle\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UtilsBundle\Entity\IdTrait;
use Evrinoma\UtilsBundle\Model\ActiveModel;
use FOS\UserBundle\Model\User as BaseUser;
use JMS\Serializer\Annotation\Type;

/**
 * Class User
 *
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    use IdTrait;

//region SECTION: Fields
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", nullable=false)
     *
     */
    protected string $surname = '';

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", nullable=false)
     */
    protected string $name = '';

    /**
     * @var string
     *
     * @ORM\Column(name="patronymic", type="string", nullable=false)
     */
    protected string $patronymic = '';

    /**
     * @var ?DateTimeImmutable
     * @Type("DateTimeImmutable<'d-m-Y'>")
     * @ORM\Column(name="expired_at", type="datetime_immutable", nullable=true)
     */
    protected ?DateTimeImmutable $expiredAt;
//endregion Fields

//region SECTION: Getters/Setters
    public function getFio(): string
    {
        $fi = ($this->surname !== '' && $this->name !== '') ? $this->surname.' '.mb_substr($this->name, 0, 1, 'utf-8').'.' : '';
        if ($fi !== '' && $this->patronymic !== '') {
            $fi = $fi.mb_substr($this->patronymic, 0, 1, 'utf-8').'.';
        }

        return $fi ?: 'noname';
    }

    public function getActive()
    {
        return $this->isEnabled() ? ActiveModel::ACTIVE : ActiveModel::BLOCKED;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param string $patronymic
     */
    public function setPatronymic(string $patronymic): void
    {
        $this->patronymic = $patronymic;
    }

    /**
     * @param string $surname
     */
    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return ?DateTimeImmutable
     */
    public function getExpiredAt(): ?DateTimeImmutable
    {
        return $this->expiredAt;
    }

    /**
     * @param ?DateTimeImmutable $expiredAt
     */
    public function setExpiredAt(?DateTimeImmutable $expiredAt): void
    {
        $this->expiredAt = $expiredAt;
    }
//endregion Getters/Setters
}