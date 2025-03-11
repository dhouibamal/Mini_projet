<?php

namespace App\Entity;

use App\Repository\HotelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HotelRepository::class)]
class Hotel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(length: 255)]
    private ?string $categorie = null;

    #[ORM\Column]
    private ?float $defaultPrice = null;

    #[ORM\ManyToOne(inversedBy: 'hotels')]
    private ?User $user = null;

    /**
     * @var Collection<int, HotelPhoto>
     */
    #[ORM\OneToMany(targetEntity: HotelPhoto::class, mappedBy: 'hotel', orphanRemoval: true)]
    private Collection $hotelPhotos;

    public function __construct()
    {
        $this->hotelPhotos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getDefaultPrice(): ?float
    {
        return $this->defaultPrice;
    }

    public function setDefaultPrice(float $defaultPrice): static
    {
        $this->defaultPrice = $defaultPrice;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, HotelPhoto>
     */
    public function getHotelPhotos(): Collection
    {
        return $this->hotelPhotos;
    }

    public function addHotelPhoto(HotelPhoto $hotelPhoto): static
    {
        if (!$this->hotelPhotos->contains($hotelPhoto)) {
            $this->hotelPhotos->add($hotelPhoto);
            $hotelPhoto->setHotel($this);
        }

        return $this;
    }

    public function removeHotelPhoto(HotelPhoto $hotelPhoto): static
    {
        if ($this->hotelPhotos->removeElement($hotelPhoto)) {
            // set the owning side to null (unless already changed)
            if ($hotelPhoto->getHotel() === $this) {
                $hotelPhoto->setHotel(null);
            }
        }

        return $this;
    }
}
