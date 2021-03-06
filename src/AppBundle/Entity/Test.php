<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Test
 *
 * @ORM\Table(name="test")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TestRepository")
 */
class Test
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="test")
     */
    private $answers;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="tests")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string");
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="psyche", type="integer", nullable=true)
     */
    private $psyche;

    /**
     * @var integer
     *
     * @ORM\Column(name="tactic", type="integer", nullable=true)
     */
    private $tactic;

    /**
     * @var integer
     *
     * @ORM\Column(name="strength", type="integer", nullable=true)
     */
    private $strength;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    /**
     * Add answer
     *
     * @param \AppBundle\Entity\Answer $answer
     *
     * @return Test
     */
    public function addAnswer(\AppBundle\Entity\Answer $answer)
    {
        $this->answers[] = $answer;

        return $this;
    }

    /**
     * Remove answer
     *
     * @param \AppBundle\Entity\Answer $answer
     */
    public function removeAnswer(\AppBundle\Entity\Answer $answer)
    {
        $this->answers->removeElement($answer);
    }

    /**
     * Get answers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Test
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Test
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }


    /**
     * Set description
     *
     * @param string $description
     *
     * @return Test
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set psyche
     *
     * @param integer $psyche
     *
     * @return Test
     */
    public function setPsyche($psyche)
    {
        $this->psyche = $psyche;

        return $this;
    }

    /**
     * Get psyche
     *
     * @return integer
     */
    public function getPsyche()
    {
        return $this->psyche;
    }

    /**
     * Set tactic
     *
     * @param integer $tactic
     *
     * @return Test
     */
    public function setTactic($tactic)
    {
        $this->tactic = $tactic;

        return $this;
    }

    /**
     * Get tactic
     *
     * @return integer
     */
    public function getTactic()
    {
        return $this->tactic;
    }


    /**
     * Set strength
     *
     * @param integer $strength
     *
     * @return Test
     */
    public function setStrength($strength)
    {
        $this->strength = $strength;

        return $this;
    }

    /**
     * Get strength
     *
     * @return integer
     */
    public function getStrength()
    {
        return $this->strength;
    }

    public function __toString()
    {
        return $this->description;
    }
}
