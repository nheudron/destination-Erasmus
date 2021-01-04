<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Prerequisites
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="Prerequisites")
 */
class Prerequisites
{
    /**
     * @var int
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id()
     * @ORM\Column(type="integer", name="prer_id")
     */
    private $id = 0;

    /**
     * @var string
     * @ORM\Column(type="string", name="prer_name", length=255, nullable=false)
     */
    private $name = "";

    /**
     * @var int
     * @ORM\Column(type="integer", name="prer_year")
     */
    private $year = 0;

    /**
     * @ORM\ManyToMany(targetEntity=Universities::class, mappedBy="prerequisites")
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
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear(int $year): void
    {
        $this->year = $year;
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
            $university->addPrerequisite($this);
        }
        return $this;
    }

    public function removeUniversity(Universities $university): self
    {
        if ($this->universities->removeElement($university)) {
            $university->removePrerequisite($this);
        }
        return $this;
    }
}