<?php

namespace App\Entity;

use App\Repository\PointRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PointRepository::class)]
class Point
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomPoint = null;

    #[ORM\Column]
    private ?int $nbSsymptomatiques = null;

    #[ORM\ManyToOne(inversedBy: 'point_surveillance')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Zone $zone = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbHabitants = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbPositifs = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPoint(): ?string
    {
        return $this->nomPoint;
    }

    public function setNomPoint(string $nomPoint): static
    {
        $this->nomPoint = $nomPoint;

        return $this;
    }

    public function getNbSymptomatiques(): ?int
    {
        return $this->nbSsymptomatiques;
    }

    public function setNbSymptomatiques(int $nbSsymptomatiques): static
    {
        $this->nbSsymptomatiques = $nbSsymptomatiques;

        return $this;
    }
    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): static
    {
        $this->zone = $zone;

        return $this;
    }

    public function getNbHabitants(): ?int
    {
        return $this->nbHabitants;
    }

    public function setNbHabitants(?int $nbHabitants): static
    {
        $this->nbHabitants = $nbHabitants;

        return $this;
    }

    public function getNbPositifs(): ?int
    {
        return $this->nbPositifs;
    }

    public function setNbPositifs(?int $nbPositifs): static
    {
        $this->nbPositifs = $nbPositifs;

        return $this;
    }
}
