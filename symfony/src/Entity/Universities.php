<?php

namespace App\Entity;

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
     * @var int
     * @ORM\Column(type="integer", name="univ_favorites")
     */
    private $favorites = 0;

    /**
     * @var string
     * @ORM\Column(type="string", name="univ_language")
     */
    private $language = "";

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
     * @return int
     */
    public function getFavorites(): int
    {
        return $this->favorites;
    }

    /**
     * @param int $favorites
     */
    public function setFavorites(int $favorites): void
    {
        $this->favorites = $favorites;
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
}