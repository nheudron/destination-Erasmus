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
     * @ORM\Column(type="boolean", name="univ_dormitories")
     */
    private $dormitories = false;

    /**
     * @ORM\ManyToMany(targetEntity=Users::class, mappedBy="favorites")
     */
    private $favUsersList;

    /**
     * @ORM\JoinColumn(name="univ_city", referencedColumnName="city_id")
     * @ORM\ManyToOne(targetEntity="Cities", inversedBy="city_universities")
     */
    private $univ_city;

    /**
     * @var ArrayCollection|null
     * @ORM\JoinColumn(name="univ_questions", referencedColumnName="ques_id")
     * @ORM\OneToMany(targetEntity="Questions", mappedBy="ques_universities")
     */
    private $univ_questions;

    /**
     * @var ArrayCollection|null
     * @ORM\JoinColumn(name="univ_comments", referencedColumnName="comm_id")
     * @ORM\OneToMany(targetEntity="Comments", mappedBy="comm_universities")
     */
    private $univ_comments;

    /**
     * @ORM\ManyToMany(targetEntity=Majors::class, inversedBy="universities")
     * @ORM\JoinTable(name="univ_majors",
     *      joinColumns={@ORM\JoinColumn(name="univ_id", referencedColumnName="univ_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="major_id", referencedColumnName="major_id")}
     * )
     */
    private $majors;

    /**
     * @ORM\ManyToMany(targetEntity=Accommodations::class, inversedBy="universities")
     * @ORM\JoinTable(name="univ_accommodations",
     *      joinColumns={@ORM\JoinColumn(name="univ_id", referencedColumnName="univ_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="acco_id", referencedColumnName="acco_id")}
     * )
     */
    private $accommodations;

    /**
     * @ORM\ManyToMany(targetEntity=Prerequisites::class, inversedBy="universities")
     * @ORM\JoinTable(name="univ_prerequisites",
     *      joinColumns={@ORM\JoinColumn(name="univ_id", referencedColumnName="univ_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="prer_id", referencedColumnName="prer_id")}
     * )
     */
    private $prerequisites;

    /**
     * @ORM\ManyToMany(targetEntity=Subjects::class, inversedBy="universities")
     * @ORM\JoinTable(name="univ_subjects",
     *      joinColumns={@ORM\JoinColumn(name="univ_id", referencedColumnName="univ_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="subj_id", referencedColumnName="subj_id")}
     * )
     */
    private $subjects;

    public function __construct()
    {
        $this->favUsersList = new ArrayCollection();
        $this->univ_comments = new ArrayCollection();
        $this->majors = new ArrayCollection();
        $this->accommodations = new ArrayCollection();
        $this->prerequisites = new ArrayCollection();
        $this->subjects = new ArrayCollection();
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
     * @return ArrayCollection|null
     */
    public function getUnivQuestions(): ?ArrayCollection
    {
        return $this->univ_questions;
    }

    /**
     * @param ArrayCollection|null $univ_questions
     */
    public function setUnivQuestions(?ArrayCollection $univ_questions): void
    {
        $this->univ_questions = $univ_questions;
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
     * @return Collection|Accommodations[]
     */
    public function getAccommodations(): Collection
    {
        return $this->accommodations;
    }

    public function addAccommodation(Accommodations $acco): self
    {
        if (!$this->accommodations->contains($acco)) {
            $this->accommodations[] = $acco;
        }
        return $this;
    }

    public function removeAccommodation(Accommodations $acco): self
    {
        $this->accommodations->removeElement($acco);
        return $this;
    }

    /**
     * @return Collection|Prerequisites[]
     */
    public function getPrerequisites(): Collection
    {
        return $this->accommodations;
    }

    public function addPrerequisite(Prerequisites $prer): self
    {
        if (!$this->prerequisites->contains($prer)) {
            $this->prerequisites[] = $prer;
        }
        return $this;
    }

    public function removePrerequisite(Prerequisites $prer): self
    {
        $this->prerequisites->removeElement($prer);
        return $this;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getUnivComments(): ?ArrayCollection
    {
        return $this->univ_comments;
    }

    /**
     * @param ArrayCollection|null $univ_comments
     */
    public function setUnivComments(?ArrayCollection $univ_comments): void
    {
        $this->univ_comments = $univ_comments;
    }

    /**
     * @return Collection|Subjects[]
     */
    public function getSubjects(): Collection
    {
        return $this->subjects;
    }

    public function addSubject(Subjects $subj): self
    {
        if (!$this->subjects->contains($subj)) {
            $this->subjects[] = $subj;
        }
        return $this;
    }

    public function removeSubject(Subjects $subj): self
    {
        $this->subjects->removeElement($subj);
        return $this;
    }
}