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
    public function __construct()
    {
        $today = new \DateTime('now');
        $this->year = $today->format('Y');
    }
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

    /**
     * @var Universities|null
     * @ORM\JoinColumn(name="comm_universities", referencedColumnName="univ_id")
     * @ORM\ManyToOne(targetEntity="Universities", inversedBy="univ_comments")
     */
    private $comm_universities;

    /**
     * @var Users|null
    * @ORM\JoinColumn(name="author", referencedColumnName="user_id")
    * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="user_comments")
    */
    private $author;

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
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear(int $year): void
    {
        $this->year = $year;
    }


    public function getCommUniversities(): universities
    {
        return $this->comm_universities;
    }

    public function setCommUniversities(Universities $comm_universities): void
    {
        $this->comm_universities = $comm_universities;
    }

    public function getAuthor(): users
    {
        return $this->author;
    }

    public function setAuthor(users $author): void
    {
        $this->author = $author;
    }

}