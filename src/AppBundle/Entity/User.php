<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @ORM\OneToMany(targetEntity="Test", mappedBy="user")
     */
    private $tests;

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
     * Add test
     *
     * @param \AppBundle\Entity\Test $test
     *
     * @return User
     */
    public function addTest(\AppBundle\Entity\Test $test)
    {
        $this->tests[] = $test;

        return $this;
    }

    /**
     * Remove test
     *
     * @param \AppBundle\Entity\Test $test
     */
    public function removeTest(\AppBundle\Entity\Test $test)
    {
        $this->tests->removeElement($test);
    }

    /**
     * Get tests
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTests()
    {
        return $this->tests;
    }
}
