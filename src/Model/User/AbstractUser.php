<?php

namespace Evrinoma\UserBundle\Model\User;


use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UserBundle\Voter\RoleInterface;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Evrinoma\UtilsBundle\Entity\IdTrait;

abstract class AbstractUser implements UserInterface
{
    use IdTrait, ActiveTrait;

//region SECTION: Fields
    /**
     * @var string
     */
    protected string $username;

    /**
     * @var string
     */
    protected string $email;

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
     * @ORM\Column(name="patronymic", type="string", nullable=true)
     */
    protected string $patronymic = '';

    /**
     * @var ?DateTimeImmutable
     *
     * @ORM\Column(name="expired_at", type="datetime_immutable", nullable=true)
     */
    protected ?DateTimeImmutable $expiredAt;

    /**
     * The salt to use for hashing.
     *
     * @var string
     * @ORM\Column(name="salt", type="string", nullable=false)
     */
    protected string $salt;

    /**
     * Encrypted password. Must be persisted.
     *
     * @var string
     * @ORM\Column(name="password", type="string", nullable=false)
     */
    protected string $password;

    /**
     * Plain password. Used for model validation. Must not be persisted.
     *
     * @var string
     */
    protected string $plainPassword;

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
    public function addRole(string $role): void
    {
        $role = strtoupper($role);
        if ($role !== RoleInterface::ROLE_DEFAULT) {
            if (!in_array($role, $this->roles, true)) {
                $this->roles[] = $role;
            }
        }
    }

    public function hasRole(string $role): bool
    {
        return in_array(strtoupper($role), $this->getRoles(), true);
    }

    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
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

    public function getSalt(): string
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
     * @return string
     */
    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    /**
     * @param DateTimeImmutable|null $lastLogin
     */
    public function setLastLogin(?DateTimeImmutable $lastLogin): void
    {
        $this->lastLogin = $lastLogin;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string $surname
     */
    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
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
     * @param DateTimeImmutable|null $expiredAt
     */
    public function setExpiredAt(?DateTimeImmutable $expiredAt): void
    {
        $this->expiredAt = $expiredAt;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }
//endregion Getters/Setters
}