<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'il ya deja un compte avec ce pseudo')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var Collection<int, Hotel>
     */
    #[ORM\OneToMany(targetEntity: Hotel::class, mappedBy: 'user')]
    private Collection $hotels;

    public function __construct()
    {
        $this->hotels = new ArrayCollection();
        $this->roles = ['ROLE_USER']; // Par défaut, un utilisateur a le rôle 'ROLE_USER'
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    // Cette méthode est obligatoire pour l'interface UserInterface
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    // Cette méthode est obligatoire pour l'interface UserInterface
    public function getRoles(): array
    {
        // Il est important de s'assurer que l'utilisateur ait au moins le rôle 'ROLE_USER'
        return $this->roles;
    }

    // Cette méthode est obligatoire pour l'interface UserInterface
    public function eraseCredentials(): void
    {
        // Aucune donnée sensible à effacer ici
    }

    // La méthode getSalt() est généralement inutile si tu utilises des algorithmes modernes comme bcrypt ou argon2
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @return Collection<int, Hotel>
     */
    public function getHotels(): Collection
    {
        return $this->hotels;
    }

    public function addHotel(Hotel $hotel): static
    {
        if (!$this->hotels->contains($hotel)) {
            $this->hotels->add($hotel);
            $hotel->setUser($this);
        }

        return $this;
    }

    public function removeHotel(Hotel $hotel): static
    {
        if ($this->hotels->removeElement($hotel)) {
            // set the owning side to null (unless already changed)
            if ($hotel->getUser() === $this) {
                $hotel->setUser(null);
            }
        }

        return $this;
    }
}
