<?php

namespace App\Entity;

use App\Repository\RegionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RegionRepository::class)]
class Region
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
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255)]
    #[Groups(['region:read'])]
    private ?string $slug = null;

    /**
     * @var Collection<int, Hospital>
     */
    #[ORM\OneToMany(targetEntity: Hospital::class, mappedBy: 'region', orphanRemoval: true)]
    #[Groups(['region:read'])]
    private Collection $hospitals;

    public function __construct()
    {
        $this->hospitals = new ArrayCollection();
    }

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, Hospital>
     */
    public function getHospitals(): Collection
    {
        return $this->hospitals;
    }

    public function addHospital(Hospital $hospital): static
    {
        if (!$this->hospitals->contains($hospital)) {
            $this->hospitals->add($hospital);
            $hospital->setRegion($this);
        }

        return $this;
    }

    public function removeHospital(Hospital $hospital): static
    {
        if ($this->hospitals->removeElement($hospital)) {
            // set the owning side to null (unless already changed)
            if ($hospital->getRegion() === $this) {
                $hospital->setRegion(null);
            }
        }

        return $this;
    }
}
