<?php

namespace App\Entity;

use App\Repository\OrderContactRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderContactRepository::class)]
class OrderContact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $contactMode = null;

    #[ORM\Column(type: 'text')]
    private ?string $reason = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $contactedAt = null;

    #[ORM\ManyToOne(inversedBy: 'orderContacts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $customerOrder = null;

    #[ORM\ManyToOne(inversedBy: 'orderContacts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $contactedBy = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContactMode(): ?string
    {
        return $this->contactMode;
    }

    public function setContactMode(string $contactMode): static
    {
        $this->contactMode = $contactMode;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(string $reason): static
    {
        $this->reason = $reason;

        return $this;
    }

    public function getContactedAt(): ?\DateTimeImmutable
    {
        return $this->contactedAt;
    }

    public function setContactedAt(\DateTimeImmutable $contactedAt): static
    {
        $this->contactedAt = $contactedAt;

        return $this;
    }

    public function getCustomerOrder(): ?Order
    {
        return $this->customerOrder;
    }

    public function setCustomerOrder(?Order $customerOrder): static
    {
        $this->customerOrder = $customerOrder;

        return $this;
    }

    public function getContactedBy(): ?User
    {
        return $this->contactedBy;
    }

    public function setContactedBy(?User $contactedBy): static
    {
        $this->contactedBy = $contactedBy;

        return $this;
    }
}
