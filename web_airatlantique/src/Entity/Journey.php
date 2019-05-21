<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JourneyRepository")
 */
class Journey
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Ticket", mappedBy="journey", cascade={"persist", "remove"})
     */
    private $ticket;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Fly", inversedBy="journeys")
     */
    private $flies;

    public function __construct()
    {
        $this->flies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTicket(): ?Ticket
    {
        return $this->ticket;
    }

    public function setTicket(Ticket $ticket): self
    {
        $this->ticket = $ticket;

        // set the owning side of the relation if necessary
        if ($this !== $ticket->getJourney()) {
            $ticket->setJourney($this);
        }

        return $this;
    }

    /**
     * @return Collection|fly[]
     */
    public function getFlies(): Collection
    {
        return $this->flies;
    }

    public function addFly(fly $fly): self
    {
        if (!$this->flies->contains($fly)) {
            $this->flies[] = $fly;
        }

        return $this;
    }

    public function removeFly(fly $fly): self
    {
        if ($this->flies->contains($fly)) {
            $this->flies->removeElement($fly);
        }

        return $this;
    }
}
