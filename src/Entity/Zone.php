<?php

namespace App\Entity;

use App\Repository\ZoneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ZoneRepository::class)]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomZone = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;
    /**
     * @var Collection<int, Point>
     */
    #[ORM\OneToMany(targetEntity: Point::class, mappedBy: 'zone', orphanRemoval: true)]
    private ?Collection $point_surveillance;

    #[ORM\ManyToOne(inversedBy: 'zones')]
    #[ORM\JoinColumn(nullable: false)]
    private Pays $pays;


    public function __construct()
    {
        $this->point_surveillance = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomZone(): ?string
    {
        return $this->nomZone;
    }

    public function setNomZone(string $nomZone): static
    {
        $this->nomZone = $nomZone;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }





    /**
     * @return Collection<int, Point>
     */
    public function getPointSurveillance(): Collection
    {
        return $this->point_surveillance;
    }

    public function addPointSurveillance(Point $pointSurveillance): static
    {
        if (!$this->point_surveillance->contains($pointSurveillance)) {
            $this->point_surveillance->add($pointSurveillance);
            $pointSurveillance->setZone($this);
        }

        return $this;
    }

    public function removePointSurveillance(Point $pointSurveillance): static
    {
        if ($this->point_surveillance->removeElement($pointSurveillance)) {
            // set the owning side to null (unless already changed)
            if ($pointSurveillance->getZone() === $this) {
                $pointSurveillance->setZone(null);
            }
        }

        return $this;
    }

    public function getPays(): ?Pays
    {
        return $this->pays;
    }

    public function setPays(?Pays $pays): static
    {
        $this->pays = $pays;

        return $this;
    }

}
