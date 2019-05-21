<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TripRepository")
 */
class Trip
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Airport")
     * @ORM\JoinColumn(nullable=false)
     */
    private $airport_start;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Airport")
     * @ORM\JoinColumn(nullable=false)
     */
    private $airport_end;

    public function getId(): ?int
    {
        return $this->id;
    }

        public function getAirportStart(): ?airport
    {
        return $this->airport_start;
    }

    public function setAirportStart(?airport $airport_start): self
    {
        $this->airport_start = $airport_start;

        return $this;
    }

        public function getAirportEnd(): ?airport
    {
        return $this->airport_end;
    }

    public function setAirportEnd(?airport $airport_end): self
    {
        $this->airport_end = $airport_end;

        return $this;
    }

}
