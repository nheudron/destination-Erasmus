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

    public function __construct()
    {
        $this->favUsersList = new ArrayCollection();
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
}