<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Universities
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="Universities")
 */
class Universities
{
    /**
     * @var int
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id()
     * @ORM\Column(type="integer", name="univ_id")
     */
    private $id = 0;

    /**
     * @var string
     * @ORM\Column(type="string", name="univ_name", length=255, nullable=false)
     */
    private $name = "";

    /**
     * @var int
     * @ORM\Column(type="integer", name="univ_availablePlaces")
     */
    private $availablePlaces = 0;

    /**
     * @var string
     * @ORM\Column(type="string", name="univ_language")
     */
    private $language = "";

    /**
     * @ORM\ManyToMany(targetEntity=Users::class, mappedBy="favorites")
     */
    private $favUsersList;

    /**
     * @ORM\ManyToOne(targetEntity=Cities::class, inversedBy="city_universities")
     * @ORM\JoinColumn(name="univ_city", referencedColumnName="city_id",nullable=false)
     */
    private $univ_city;

    /**
     * @ORM\Column(type="boolean", name="univ_dormitories")
     */
    private $dormitories = false;

    /**
     * @ORM\ManyToMany(targetEntity=Majors::class, inversedBy="universities")
     * @ORM\JoinTable(name="univ_majors",
     *      joinColumns={@ORM\JoinColumn(name="univ_id", referencedColumnName="univ_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="major_id", referencedColumnName="major_id")}
     * )
     */
    private $majors;

    /**
     * @ORM\ManyToMany(targetEntity=Accomodations::class, inversedBy="universities")
     * @ORM\JoinTable(name="univ_accomodations",
     *      joinColumns={@ORM\JoinColumn(name="univ_id", referencedColumnName="univ_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="acco_id", referencedColumnName="acco_id")}
     * )
     */
    private $accomodations;

    /**
     * @ORM\ManyToMany(targetEntity=Prerequisites::class, inversedBy="universities")
     * @ORM\JoinTable(name="univ_prerequisites",
     *      joinColumns={@ORM\JoinColumn(name="univ_id", referencedColumnName="univ_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="prer_id", referencedColumnName="prer_id")}
     * )
     */
    private $prerequisites;

    /**
     * @ORM\ManyToMany(targetEntity=Comments::class, inversedBy="universities")
     * @ORM\JoinTable(name="univ_comments",
     *      joinColumns={@ORM\JoinColumn(name="univ_id", referencedColumnName="univ_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="comm_id", referencedColumnName="comm_id")}
     * )
     */
    private $comments;

    public function __construct()
    {
        $this->favUsersList = new ArrayCollection();
        $this->majors = new ArrayCollection();
        $this->accomodations = new ArrayCollection();
        $this->prerequisites = new ArrayCollection();
        $this->comments = new ArrayCollection();
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
    public function getAvailablePlaces(): int
    {
        return $this->availablePlaces;
    }

    /**
     * @param int $availablePlaces
     */
    public function setAvailablePlaces(int $availablePlaces): void
    {
        $this->availablePlaces = $availablePlaces;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    /**
     * @return Collection|Users[]
     */
    public function getFavUsersList(): Collection
    {
        return $this->favUsersList;
    }

    /**
     * @return int
     */
    public function getFavNb(): int
    {
        $nb = count($this->getFavUsersList());
        return $nb;
    }

    public function addFavUsersList(Users $favUsersList): self
    {
        if (!$this->favUsersList->contains($favUsersList)) {
            $this->favUsersList[] = $favUsersList;
            $favUsersList->addFavorite($this);
        }
        return $this;
    }

    public function removeFavUsersList(Users $favUsersList): self
    {
        if ($this->favUsersList->removeElement($favUsersList)) {
            $favUsersList->removeFavorite($this);
        }
        return $this;
    }

    public function getUnivCity(): ?Cities
    {
        return $this->univ_city;
    }

    public function setUnivCity(?Cities $univ_city): self
    {
        $this->univ_city = $univ_city;
        return $this;
    }

    public function getDormitories(): ?bool
    {
        return $this->dormitories;
    }

    public function setDormitories(bool $dormitories): self
    {
        $this->dormitories = $dormitories;
        return $this;
    }

    /**
     * @return Collection|Majors[]
     */
    public function getMajors(): Collection
    {
        return $this->majors;
    }

    public function addMajor(Majors $major): self
    {
        if (!$this->majors->contains($major)) {
            $this->majors[] = $major;
        }
        return $this;
    }

    public function removeMajor(Majors $major): self
    {
        $this->majors->removeElement($major);
        return $this;
    }

    /**
     * @return Collection|Accomodations[]
     */
    public function getAccomodations(): Collection
    {
        return $this->accomodations;
    }

    public function addAccomodation(Accomodations $acco): self
    {
        if (!$this->majors->contains($acco)) {
            $this->majors[] = $acco;
        }
        return $this;
    }

    public function removeAccomodation(Accomodations $acco): self
    {
        $this->majors->removeElement($acco);
        return $this;
    }

    /**
     * @return Collection|Prerequisites[]
     */
    public function getPrerequisites(): Collection
    {
        return $this->accomodations;
    }

    public function addPrerequisite(Prerequisites $prer): self
    {
        if (!$this->majors->contains($prer)) {
            $this->prerequisites[] = $prer;
        }
        return $this;
    }

    public function removePrerequisite(Prerequisites $prer): self
    {
        $this->majors->removeElement($prer);
        return $this;
    }

    /**
     * @return Collection|Comments[]
     */
    public function getComments(): Collection
    {
        return $this->accomodations;
    }

    public function addComment(Comments $comm): self
    {
        if (!$this->majors->contains($comm)) {
            $this->prerequisites[] = $comm;
        }
        return $this;
    }

    public function removeComment(Comments $comm): self
    {
        $this->majors->removeElement($comm);
        return $this;
    }
}