<?php

namespace App\Entity;

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
     * @ORM\Column(type="string", name="city_pres", length=255, nullable=false)
     */
    private $presentation = "";

    /**
     * @var Countries
     * @ORM\JoinColumn(name="city_country", referencedColumnName="country_id")
     * @ORM\ManyToOne(targetEntity="Countries", inversedBy="country_city")
     */
    private $city_country;

    /**
     * @var Universities|null
     * @ORM\JoinColumn(name="city_university", referencedColumnName="university_id")
     * @ORM\OneToMany(targetEntity="Universities", mappedBy="univ_city")
     */
    private $city_university;

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
     * @return Countries
     */
    public function getCityCountry(): Countries
    {
        return $this->city_country;
    }

    /**
     * @param Countries $city_country
     */
    public function setCityCountry(Countries $city_country): void
    {
        $this->city_country = $city_country;
    }

    /**
     * @return Universities|null
     */
    public function getCityUniversity(): ?Universities
    {
        return $this->city_university;
    }

    /**
     * @param Universities|null $city_university
     */
    public function setCityUniversity(?Universities $city_university): void
    {
        $this->city_university = $city_university;
    }
}