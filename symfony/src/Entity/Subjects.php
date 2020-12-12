<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Subjects
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="Subjects")
 */
class Subjects
{
    /**
     * @var int
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id()
     * @ORM\Column(type="integer", name="subj_id")
     */
    private $id = 0;

    /**
     * @var string
     * @ORM\Column(type="string", name="subj_name", length=255, nullable=false)
     */
    private $name = "";

    /**
     * @var int
     * @ORM\Column(type="integer", name="subj_credits", nullable=false)
     */
    private $credits = 0;

    /**
     * @var int
     * @ORM\Column(type="integer", name="subj_hoursPerWeek", nullable=false)
     */
    private $hoursPerWeek = 0;

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
    public function getCredits(): int
    {
        return $this->credits;
    }

    /**
     * @param int $credits
     */
    public function setCredits(int $credits): void
    {
        $this->credits = $credits;
    }

    /**
     * @return int
     */
    public function getHoursPerWeek(): int
    {
        return $this->hoursPerWeek;
    }

    /**
     * @param int $hoursPerWeek
     */
    public function setHoursPerWeek(int $hoursPerWeek): void
    {
        $this->hoursPerWeek = $hoursPerWeek;
    }
}