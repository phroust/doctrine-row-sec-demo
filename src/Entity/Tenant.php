<?php

namespace App\Entity;

use App\Repository\TenantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TenantRepository::class)]
class Tenant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $name = null;

    #[ORM\Column(length: 64)]
    private ?string $Status = null;

    #[ORM\Column(length: 64)]
    private ?string $Tier = null;

    #[ORM\OneToMany(mappedBy: 'Tenant', targetEntity: TenantUser::class, orphanRemoval: true)]
    private Collection $Users;

    public function __construct()
    {
        $this->Users = new ArrayCollection();
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

    public function getStatus(): ?string
    {
        return $this->Status;
    }

    public function setStatus(string $Status): static
    {
        $this->Status = $Status;

        return $this;
    }

    public function getTier(): ?string
    {
        return $this->Tier;
    }

    public function setTier(string $Tier): static
    {
        $this->Tier = $Tier;

        return $this;
    }

    /**
     * @return Collection<int, TenantUser>
     */
    public function getUsers(): Collection
    {
        return $this->Users;
    }

    public function addUser(TenantUser $user): static
    {
        if (!$this->Users->contains($user)) {
            $this->Users->add($user);
            $user->setTenant($this);
        }

        return $this;
    }

    public function removeUser(TenantUser $user): static
    {
        if ($this->Users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getTenant() === $this) {
                $user->setTenant(null);
            }
        }

        return $this;
    }
}
