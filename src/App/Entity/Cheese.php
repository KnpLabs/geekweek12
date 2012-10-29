<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Entity\CheeseRepository")
 */
class Cheese
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(name="region", type="string", length=255)
     */
    private $region;

    /**
     * @ORM\Column(name="milk", type="string", length=255)
     */
    private $milk;

    /**
     * @ORM\Column(name="totalRating", type="bigint")
     */
    private $totalRating;

    /**
     * @ORM\Column(name="totalVote", type="bigint")
     */
    private $totalVote;

    public function getScore()
    {
        return $totalRating / $totalVote;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    public function getRegion()
    {
        return $this->region;
    }

    public function setMilk($milk)
    {
        $this->milk = $milk;

        return $this;
    }

    public function getMilk()
    {
        return $this->milk;
    }

    public function setTotalRating($totalRating)
    {
        $this->totalRating = $totalRating;

        return $this;
    }

    public function getTotalRating()
    {
        return $this->totalRating;
    }

    public function setTotalVote($totalVote)
    {
        $this->totalVote = $totalVote;

        return $this;
    }

    public function getTotalVote()
    {
        return $this->totalVote;
    }
}
