<?php

namespace App\Entity;

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
}