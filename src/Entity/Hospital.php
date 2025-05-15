<?php

namespace App\Entity;

use App\Repository\HospitalRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: HospitalRepository::class)]
class Hospital
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['region:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['region:read'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['region:read'])]
    private ?float $latitude = null;

    #[ORM\Column]
    #[Groups(['region:read'])]
    private ?float $longitude = null;

    #[ORM\ManyToOne(inversedBy: 'hospitals')]
    #[ORM\JoinColumn(nullable: false)]
    // #[Groups(['hospital:read'])]
    private ?Region $region = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): static
    {
        $this->region = $region;

        return $this;
    }
}
