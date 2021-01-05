<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Questions
 * @package App\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="Questions")
 */
class Questions
{
    /**
     * @var int
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id()
     * @ORM\Column(type="integer", name="ques_id")
     */
    private $id = 0;

    /**
     * @var string
     * @ORM\Column(type="string", name="ques_name", length=1024, nullable=false)
     */
    private $text = "";

    /**
     * @var ArrayCollection|null
     * @ORM\JoinColumn(name="ques_responses", referencedColumnName="resp_id")
     * @ORM\OneToMany(targetEntity="Responses", mappedBy="resp_question")
     */
    private $ques_responses;

    /**
     * @var Universities|null
     * @ORM\JoinColumn(name="ques_universities", referencedColumnName="univ_id")
     * @ORM\ManyToOne(targetEntity="Universities", inversedBy="univ_questions")
     */
    private $ques_universities;

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
     * @return ArrayCollection|null
     */
    public function getQuesResponses(): ?ArrayCollection
    {
        return $this->ques_responses;
    }

    /**
     * @param ArrayCollection|null $ques_responses
     */
    public function setQuesResponses(?ArrayCollection $ques_responses): void
    {
        $this->ques_responses = $ques_responses;
    }

    /**
     * @return Universities|null
     */
    public function getQuesUniversities(): ?Universities
    {
        return $this->ques_universities;
    }

    /**
     * @param Universities|null $ques_universities
     */
    public function setQuesUniversities(?Universities $ques_universities): void
    {
        $this->ques_universities = $ques_universities;
    }
}