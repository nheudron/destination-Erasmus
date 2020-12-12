<?php

namespace App\Entity;

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
     * @var string
     * @ORM\Column(type="string", name="country_currency", length=255, nullable=false)
     */
    private $currency = "";

    /**
     * @ORM\Column(type="string", name="country_flag", length=255, nullable=false)
     */
    private $flag = "";

    /**
     * @var Cities|null
     * @ORM\JoinColumn(name="country_city", referencedColumnName="city_id")
     * @ORM\OneToMany(targetEntity="Cities", mappedBy="city_country")
     */
    private $country_city;

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
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
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
     * @return Cities|null
     */
    public function getCountryCity(): ?Cities
    {
        return $this->country_city;
    }

    /**
     * @param Cities|null $country_city
     */
    public function setCountryCity(?Cities $country_city): void
    {
        $this->country_city = $country_city;
    }
}
