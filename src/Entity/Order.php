<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 45)]
    private ?string $firstName = null;

    #[ORM\Column(length: 45)]
    private ?string $lastName = null;

    #[ORM\Column(length: 45)]
    private ?string $email = null;

    #[ORM\Column(length: 45)]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 45)]
    private ?string $city = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $deliveryDate = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTime $deliveryTime = null;

    #[ORM\Column(length: 30)]
    private ?string $status = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $menuPrice = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $deliveryPrice = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $discount = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $totalPrice = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?bool $hasBorrowedMaterial = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $distanceKm = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Menu $menu = null;

    #[ORM\OneToOne(mappedBy: 'customerOrder', targetEntity: Review::class)]
    private ?Review $review = null;

    /**
     * @var Collection<int, OrderStatusHistory>
     */
    #[ORM\OneToMany(targetEntity: OrderStatusHistory::class, mappedBy: 'orderRef')]
    private Collection $orderStatusHistories;

    /**
     * @var Collection<int, OrderContact>
     */
    #[ORM\OneToMany(targetEntity: OrderContact::class, mappedBy: 'customerOrder')]
    private Collection $orderContacts;

    public function __construct()
    {
        $this->orderStatusHistories = new ArrayCollection();
        $this->orderContacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getDeliveryDate(): ?\DateTime
    {
        return $this->deliveryDate;
    }

    public function setDeliveryDate(\DateTime $deliveryDate): static
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    public function getDeliveryTime(): ?\DateTime
    {
        return $this->deliveryTime;
    }

    public function setDeliveryTime(\DateTime $deliveryTime): static
    {
        $this->deliveryTime = $deliveryTime;

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

    public function getMenuPrice(): ?string
    {
        return $this->menuPrice;
    }

    public function setMenuPrice(string $menuPrice): static
    {
        $this->menuPrice = $menuPrice;

        return $this;
    }

    public function getDeliveryPrice(): ?string
    {
        return $this->deliveryPrice;
    }

    public function setDeliveryPrice(string $deliveryPrice): static
    {
        $this->deliveryPrice = $deliveryPrice;

        return $this;
    }

    public function getDiscount(): ?string
    {
        return $this->discount;
    }

    public function setDiscount(string $discount): static
    {
        $this->discount = $discount;

        return $this;
    }

    public function getTotalPrice(): ?string
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(string $totalPrice): static
    {
        $this->totalPrice = $totalPrice;

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

    public function hasBorrowedMaterial(): ?bool
    {
        return $this->hasBorrowedMaterial;
    }

    public function setHasBorrowedMaterial(bool $hasBorrowedMaterial): static
    {
        $this->hasBorrowedMaterial = $hasBorrowedMaterial;

        return $this;
    }

    public function getDistanceKm(): ?string
    {
        return $this->distanceKm;
    }

    public function setDistanceKm(string $distanceKm): static
    {
        $this->distanceKm = $distanceKm;

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

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): static
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * @return Collection<int, OrderStatusHistory>
     */
    public function getOrderStatusHistories(): Collection
    {
        return $this->orderStatusHistories;
    }

    public function addOrderStatusHistory(OrderStatusHistory $orderStatusHistory): static
    {
        if (!$this->orderStatusHistories->contains($orderStatusHistory)) {
            $this->orderStatusHistories->add($orderStatusHistory);
            $orderStatusHistory->setOrderRef($this);
        }

        return $this;
    }

    public function removeOrderStatusHistory(OrderStatusHistory $orderStatusHistory): static
    {
        if ($this->orderStatusHistories->removeElement($orderStatusHistory)) {
            // set the owning side to null (unless already changed)
            if ($orderStatusHistory->getOrderRef() === $this) {
                $orderStatusHistory->setOrderRef(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, OrderContact>
     */
    public function getOrderContacts(): Collection
    {
        return $this->orderContacts;
    }

    public function addOrderContact(OrderContact $orderContact): static
    {
        if (!$this->orderContacts->contains($orderContact)) {
            $this->orderContacts->add($orderContact);
            $orderContact->setCustomerOrder($this);
        }

        return $this;
    }

    public function removeOrderContact(OrderContact $orderContact): static
    {
        if ($this->orderContacts->removeElement($orderContact)) {
            // set the owning side to null (unless already changed)
            if ($orderContact->getCustomerOrder() === $this) {
                $orderContact->setCustomerOrder(null);
            }
        }

        return $this;
    }
}
