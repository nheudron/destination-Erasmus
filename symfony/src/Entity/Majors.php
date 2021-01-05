<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Majors
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="Majors")
 */
class Majors
{
    /**
     * @var int
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id()
     * @ORM\Column(type="integer", name="major_id")
     */
    private $id = 0;

    /**
     * @var string
     * @ORM\Column(type="string", name="major_name", length=255, nullable=false)
     */
    private $name = "";

    /**
     * @var string
     * @ORM\Column(type="string", name="major_branch", length=255, nullable=false)
     */
    private $branch = "";

    /**
     * @ORM\ManyToMany(targetEntity=Universities::class, mappedBy="majors")
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
     * @return string
     */
    public function getBranch(): string
    {
        return $this->branch;
    }

    /**
     * @param string $branch
     */
    public function setBranch(string $branch): void
    {
        $this->branch = $branch;
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
            $university->addMajor($this);
        }
        return $this;
    }

    public function removeUniversity(Universities $university): self
    {
        if ($this->universities->removeElement($university)) {
            $university->removeMajor($this);
        }
        return $this;
    }
}