<?php

namespace Evrinoma\UserBundle\Model\User;


use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Evrinoma\UtilsBundle\Entity\IdTrait;
use Evrinoma\UtilsBundle\Entity\NameTrait;

abstract class AbstractUser implements UserInterface
{
    use IdTrait, ActiveTrait, NameTrait;

//region SECTION: Fields
    /**
     * @var string
     */
    protected string $username = '';

    /**
     * @var string
     */
    protected string $email = '';

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
     * @ORM\Column(name="patronymic", type="string", nullable=true)
     */
    protected string $patronymic = '';

    /**
     * @var ?DateTimeImmutable
     *
     * @ORM\Column(name="expired_at", type="datetime_immutable", nullable=true)
     */
    protected ?DateTimeImmutable $expiredAt = null;

    /**
     * @var ?string
     *
     * @ORM\Column(name="salt", type="string", nullable=true)
     */
    protected ?string $salt = null;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", nullable=false)
     */
    protected string $password = '';

    /**
     * @var ?DateTimeImmutable
     *
     * @ORM\Column(name="last_login", type="datetime_immutable", nullable=true)
     */
    protected ?DateTimeImmutable $lastLogin;

    /**
     * @var array
     *
     * @ORM\Column(name="role", type="array", nullable=true)
     */
    protected array $roles = [];
//endregion Fields

//region SECTION: Public
    public function addRole(string $role): UserInterface
    {
        $role = strtoupper($role);
//        if ($role !== RoleInterface::ROLE_DEFAULT) {
        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
//            }
        }

        return $this;
    }

    public function hasRole(string $role): bool
    {
        return in_array(strtoupper($role), $this->getRoles(), true);
    }

    public function eraseCredentials(): UserInterface
    {

    }
//endregion Public

//region SECTION: Getters/Setters
    /**
     * @return DateTimeImmutable|null
     */
    public function getLastLogin(): ?DateTimeImmutable
    {
        return $this->lastLogin;
    }

    public function getFio(): string
    {
        $fi = ($this->surname !== '' && $this->name !== '') ? $this->surname.' '.mb_substr($this->name, 0, 1, 'utf-8').'.' : '';
        if ($fi !== '' && $this->patronymic !== '') {
            $fi = $fi.mb_substr($this->patronymic, 0, 1, 'utf-8').'.';
        }

        return $fi ?: 'noname';
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getSalt(): ?string
    {
        return $this->salt;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPatronymic(): string
    {
        return $this->patronymic;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getExpiredAt(): ?DateTimeImmutable
    {
        return $this->expiredAt;
    }

    /**
     * @param string $password
     *
     * @return UserInterface
     */
    public function setPassword(string $password): UserInterface
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param DateTimeImmutable|null $lastLogin
     *
     * @return UserInterface
     */
    public function setLastLogin(?DateTimeImmutable $lastLogin): UserInterface
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * @param string $username
     *
     * @return UserInterface
     */
    public function setUsername(string $username): UserInterface
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @param string $email
     *
     * @return UserInterface
     */
    public function setEmail(string $email): UserInterface
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param string $surname
     *
     * @return UserInterface
     */
    public function setSurname(string $surname): UserInterface
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @param string $patronymic
     *
     * @return UserInterface
     */
    public function setPatronymic(string $patronymic): UserInterface
    {
        $this->patronymic = $patronymic;

        return $this;
    }

    /**
     * @param DateTimeImmutable|null $expiredAt
     *
     * @return UserInterface
     */
    public function setExpiredAt(?DateTimeImmutable $expiredAt): UserInterface
    {
        $this->expiredAt = $expiredAt;

        return $this;
    }
//endregion Getters/Setters
}