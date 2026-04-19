<?php

namespace App\Entity;

use App\Repository\OpeningHoursRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OpeningHoursRepository::class)]
class OpeningHours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $day = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTime $openingTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTime $closingTime = null;

    #[ORM\Column]
    private ?bool $isClosed = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): static
    {
        $this->day = $day;

        return $this;
    }

    public function getOpeningTime(): ?\DateTime
    {
        return $this->openingTime;
    }

    public function setOpeningTime(?\DateTime $openingTime): static
    {
        $this->openingTime = $openingTime;

        return $this;
    }

    public function getClosingTime(): ?\DateTime
    {
        return $this->closingTime;
    }

    public function setClosingTime(?\DateTime $closingTime): static
    {
        $this->closingTime = $closingTime;

        return $this;
    }

    public function isClosed(): ?bool
    {
        return $this->isClosed;
    }

    public function setIsClosed(bool $isClosed): static
    {
        $this->isClosed = $isClosed;

        return $this;
    }
}
