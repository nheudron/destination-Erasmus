<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Responses
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="Responses")
 */
class Responses
{
    /**
     * @var int
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id()
     * @ORM\Column(type="integer", name="resp_id")
     */
    private $id = 0;

    /**
     * @var string
     * @ORM\Column(type="string", name="resp_name", length=1024, nullable=false)
     */
    private $text = "";

    /**
     * @var Questions|null
     * @ORM\JoinColumn(name="resp_questions", referencedColumnName="ques_id")
     * @ORM\ManyToOne(targetEntity="Questions", inversedBy="ques_responses")
     */
    private $resp_questions;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return Questions|null
     */
    public function getRespQuestions(): ?Questions
    {
        return $this->resp_questions;
    }

    /**
     * @param Questions|null $resp_questions
     */
    public function setRespQuestions(?Questions $resp_questions): void
    {
        $this->resp_questions = $resp_questions;
    }
}