<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Cities
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="Cities")
 */
class Cities
{
    /**
     * @var int
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id()
     * @ORM\Column(type="integer", name="city_id")
     */
    private $id = 0;

    /**
     * @var string
     * @ORM\Column(type="string", name="city_name", length=255, nullable=false)
     */
    private $name = "";

    /**
     * @var int
     * @ORM\Column(type="integer", name="city_inhabitants", nullable=false)
     */
    private $inhabitants = 0;

    /**
     * @var string
     * @ORM\Column(type="text", name="city_pres", length=6553, nullable=false)
     */
    private $presentation = "";

    /**
     * @ORM\OneToMany(targetEntity=Universities::class, mappedBy="univ_city")
     */
    private $city_universities;

    /**
     * @ORM\ManyToOne(targetEntity=Countries::class, inversedBy="country_cities")
     * @ORM\JoinColumn(name="city_country", referencedColumnName="country_id",nullable=false)
     */
    private $city_country;

    public function __construct()
    {
        $this->city_universities = new ArrayCollection();
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
    public function getInhabitants(): int
    {
        return $this->inhabitants;
    }

    /**
     * @param int $inhabitants
     */
    public function setInhabitants(int $inhabitants): void
    {
        $this->inhabitants = $inhabitants;
    }
    
    /**
     * @return string
     */
    public function getPresentation(): string
    {
        return $this->presentation;
    }

    /**
     * @param string $presentation
     */
    public function setPresentation(string $presentation): void
    {
        $this->presentation = $presentation;
    }

    /**
     * @return Collection|Universities[]
     */
    public function getCityUniversities(): Collection
    {
        return $this->city_universities;
    }

    public function addCityUniversity(Universities $cityUniversity): self
    {
        if (!$this->city_universities->contains($cityUniversity)) {
            $this->city_universities[] = $cityUniversity;
            $cityUniversity->setUnivCity($this);
        }

        return $this;
    }

    public function removeCityUniversity(Universities $cityUniversity): self
    {
        if ($this->city_universities->removeElement($cityUniversity)) {
            // set the owning side to null (unless already changed)
            if ($cityUniversity->getUnivCity() === $this) {
                $cityUniversity->setUnivCity(null);
            }
        }

        return $this;
    }

    public function getCityCountry(): ?Countries
    {
        return $this->city_country;
    }

    public function setCityCountry(?Countries $city_country): self
    {
        $this->city_country = $city_country;

        return $this;
    }
}