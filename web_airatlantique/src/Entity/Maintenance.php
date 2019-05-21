<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MaintenanceRepository")
 */
class Maintenance
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
    private $startDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $plannedDate;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Incident", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $incident;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Employee")
     */
    private $employee;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $report;

    public function __construct()
    {
        $this->employee = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getPlannedDate(): ?\DateTimeInterface
    {
        return $this->plannedDate;
    }

    public function setPlannedDate(\DateTimeInterface $plannedDate): self
    {
        $this->plannedDate = $plannedDate;

        return $this;
    }

    public function getIncident(): ?incident
    {
        return $this->incident;
    }

    public function setIncident(incident $incident): self
    {
        $this->incident = $incident;

        return $this;
    }

    /**
     * @return Collection|employee[]
     */
    public function getEmployee(): Collection
    {
        return $this->employee;
    }

    public function addEmployee(employee $employee): self
    {
        if (!$this->employee->contains($employee)) {
            $this->employee[] = $employee;
        }

        return $this;
    }

    public function removeEmployee(employee $employee): self
    {
        if ($this->employee->contains($employee)) {
            $this->employee->removeElement($employee);
        }

        return $this;
    }

    public function getReport(): ?string
    {
        return $this->report;
    }

    public function setReport(string $report): self
    {
        $this->report = $report;

        return $this;
    }
}
