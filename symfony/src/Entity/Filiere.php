<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Filiere
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="Filiere")
 */
class Filiere
{
    /**
     * @var int
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id()
     * @ORM\Column(type="integer", name="filiere_id")
     */
    private $id = 0;

    /**
     * @var string
     * @ORM\Column(type="string", name="name", length=255, nullable=false)
     */
    private $name = "";

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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
