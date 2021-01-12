<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Countries
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="Countries")
 */
class Countries
{
    /**
     * @var int
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id()
     * @ORM\Column(type="integer", name="country_id")
     */
    private $id = 0;

    /**
     * @var string
     * @ORM\Column(type="string", name="country_name", length=255, nullable=false)
     */
    private $name = "";

    /**
     * @var string
     * @ORM\Column(type="string", name="country_lang", length=255, nullable=false)
     */
    private $language = "";

    /**
     * @ORM\Column(type="string", name="country_flag", length=255, nullable=false)
     */
    private $flag = "";

    /**
     * @ORM\OneToMany(targetEntity=Cities::class, mappedBy="city_country")
     */
    private $country_cities;

    public function __construct()
    {
        $this->country_cities = new ArrayCollection();
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
     * @return mixed
     */
    public function getFlag()
    {
        return $this->flag;
    }

    /**
     * @param mixed $flag
     */
    public function setFlag($flag): void
    {
        $this->flag = $flag;
    }

    /**
     * @return Collection|Cities[]
     */
    public function getCountryCities(): Collection
    {
        return $this->country_cities;
    }

    public function addCountryCity(Cities $countryCity): self
    {
        if (!$this->country_cities->contains($countryCity)) {
            $this->country_cities[] = $countryCity;
            $countryCity->setCityCountry($this);
        }

        return $this;
    }

    public function removeCountryCity(Cities $countryCity): self
    {
        if ($this->country_cities->removeElement($countryCity)) {
            // set the owning side to null (unless already changed)
            if ($countryCity->getCityCountry() === $this) {
                $countryCity->setCityCountry(null);
            }
        }

        return $this;
    }
}
