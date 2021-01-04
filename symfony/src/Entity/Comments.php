<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Comments
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="Comments")
 */
class Comments
{
    /**
     * @var int
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id()
     * @ORM\Column(type="integer", name="comm_id")
     */
    private $id = 0;

    /**
     * @var string
     * @ORM\Column(type="string", name="comm_comm", length=2047, nullable=false)
     */
    private $comment = "";

    /**
     * @var int
     * @ORM\Column(type="integer", name="comm_year")
     */
    private $year = 0;

    //0=simple comm; 1=question; 2=response
    /**
     * @var int
     * @ORM\Column(type="integer", name="comm_value")
     */
    private $value = 0;

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
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
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
            $university->addComment($this);
        }
        return $this;
    }

    public function removeUniversity(Universities $university): self
    {
        if ($this->universities->removeElement($university)) {
            $university->removeComment($this);
        }
        return $this;
    }
}