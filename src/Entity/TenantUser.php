<?php

namespace App\Entity;

use App\Repository\TenantUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TenantUserRepository::class)]
class TenantUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'Users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tenant $Tenant = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $Email = null;

    #[ORM\Column(length: 255)]
    private ?string $GivenName = null;

    #[ORM\Column(length: 255)]
    private ?string $FamilyName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTenant(): ?Tenant
    {
        return $this->Tenant;
    }

    public function setTenant(?Tenant $Tenant): static
    {
        $this->Tenant = $Tenant;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    public function getGivenName(): ?string
    {
        return $this->GivenName;
    }

    public function setGivenName(string $GivenName): static
    {
        $this->GivenName = $GivenName;

        return $this;
    }

    public function getFamilyName(): ?string
    {
        return $this->FamilyName;
    }

    public function setFamilyName(string $FamilyName): static
    {
        $this->FamilyName = $FamilyName;

        return $this;
    }
}
