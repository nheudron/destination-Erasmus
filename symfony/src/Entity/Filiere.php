<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(type="string", name="filiere_name", length=255, nullable=false)
     */
    private $name = "";

    /**
     * @ORM\ManyToMany(targetEntity=Universities::class, mappedBy="filieres")
     */
    private $universities;

    public function __construct()
    {
        $this->universities = new ArrayCollection();
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

    /**
     * @return Collection|Universities[]
     */
    public function getUniversities(): Collection
    {
        return $this->universities;
    }

    public function addUniversity(Universities $university): self
    {
        if (!$this->universities->contains($university)) {
            $this->universities[] = $university;
            $university->addFiliere($this);
        }

        return $this;
    }

    public function removeUniversity(Universities $university): self
    {
        if ($this->universities->removeElement($university)) {
            $university->removeFiliere($this);
        }

        return $this;
    }
}
