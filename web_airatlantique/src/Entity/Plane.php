<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlaneRepository")
 */
class Plane
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Fly", mappedBy="plane")
     */
    private $flies;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\State")
     * @ORM\JoinColumn(nullable=false)
     */
    private $state;

    /**
     * @ORM\Column(type="integer")
     */
    private $economic;

    /**
     * @ORM\Column(type="integer")
     */
    private $buisness;

    /**
     * @ORM\Column(type="integer")
     */
    private $premium;

    public function __construct()
    {
        $this->flies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Fly[]
     */
    public function getFlies(): Collection
    {
        return $this->flies;
    }

    public function addFly(Fly $fly): self
    {
        if (!$this->flies->contains($fly)) {
            $this->flies[] = $fly;
            $fly->setPlane($this);
        }

        return $this;
    }

    public function removeFly(Fly $fly): self
    {
        if ($this->flies->contains($fly)) {
            $this->flies->removeElement($fly);
            // set the owning side to null (unless already changed)
            if ($fly->getPlane() === $this) {
                $fly->setPlane(null);
            }
        }

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getState(): ?state
    {
        return $this->state;
    }

    public function setState(?state $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getEconomic(): ?int
    {
        return $this->economic;
    }

    public function setEconomic(int $economic): self
    {
        $this->economic = $economic;

        return $this;
    }

    public function getBuisness(): ?int
    {
        return $this->buisness;
    }

    public function setBuisness(int $buisness): self
    {
        $this->buisness = $buisness;

        return $this;
    }

    public function getPremium(): ?int
    {
        return $this->premium;
    }

    public function setPremium(int $premium): self
    {
        $this->premium = $premium;

        return $this;
    }
}
