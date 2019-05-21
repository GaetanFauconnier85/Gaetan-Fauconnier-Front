<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FlyRepository")
 */
class Fly
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $hour_start;

    /**
     * @ORM\Column(type="datetime")
     */
    private $hour_end;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Journey", mappedBy="flies")
     */
    private $journeys;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trip")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trip_used;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Plane", inversedBy="flies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $plane;

    public function __construct()
    {
        $this->journeys = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHourStart(): ?\DateTimeInterface
    {
        return $this->hour_start;
    }

    public function setHourStart(\DateTimeInterface $hour_start): self
    {
        $this->hour_start = $hour_start;

        return $this;
    }

    public function getHourEnd(): ?\DateTimeInterface
    {
        return $this->hour_end;
    }

    public function setHourEnd(\DateTimeInterface $hour_end): self
    {
        $this->hour_end = $hour_end;

        return $this;
    }

    /**
     * @return Collection|Journey[]
     */
    public function getJourneys(): Collection
    {
        return $this->journeys;
    }

    public function addJourney(Journey $journey): self
    {
        if (!$this->journeys->contains($journey)) {
            $this->journeys[] = $journey;
            $journey->addFly($this);
        }

        return $this;
    }

    public function removeJourney(Journey $journey): self
    {
        if ($this->journeys->contains($journey)) {
            $this->journeys->removeElement($journey);
            $journey->removeFly($this);
        }

        return $this;
    }

    public function getTripUsed(): ?trip
    {
        return $this->trip_used;
    }

    public function setTripUsed(?trip $trip_used): self
    {
        $this->trip_used = $trip_used;

        return $this;
    }

    public function getPlane(): ?plane
    {
        return $this->plane;
    }

    public function setPlane(?plane $plane): self
    {
        $this->plane = $plane;

        return $this;
    }
}
