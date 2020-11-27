<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class Users
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="Users")
 */
class Users implements UserInterface
{
    /**
     * @var int
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id()
     * @ORM\Column(type="integer", name="user_id")
     */
    private $id = 0;

    /**
     * @var string
     * @ORM\Column(type="string", name="user_lastName", length=255, nullable=false)
     */
    private $lastName = "";

    /**
     * @var string
     * @ORM\Column(type="string", name="user_firstName", length=255, nullable=false)
     */
    private $firstName = "";

    /**
     * @var string
     * @ORM\Column(type="string", name="user_email", length=255, nullable=false)
     */
    private $email = "";

    /**
     * @var string
     * @ORM\Column(type="string", name="user_password", length=1000, nullable=false)
     */
    private $password = "";

    /**
     * @var string[]
     * @ORM\Column(type="json")
     */
    private $roles = array();

    public function __toString()
    {
        return "{$this->lastName} " . "{$this->firstName}";
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getUsername() // mail is username
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param string[] $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }
}