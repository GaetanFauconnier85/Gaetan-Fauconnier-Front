<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Journey", inversedBy="ticket", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $journey;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Classe", inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?user
    {
        return $this->owner;
    }

    public function setOwner(?user $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getJourney(): ?journey
    {
        return $this->journey;
    }

    public function setJourney(journey $journey): self
    {
        $this->journey = $journey;

        return $this;
    }

    public function getType(): ?classe
    {
        return $this->type;
    }

    public function setType(?classe $type): self
    {
        $this->type = $type;

        return $this;
    }
}
