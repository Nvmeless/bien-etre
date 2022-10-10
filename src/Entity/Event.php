<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getAllEvents", "getAllAuthors"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getAllEvents", "getAllAuthors"])]
    private ?string $eventName = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["getAllEvents", "getAllAuthors"])]
    private ?float $eventPrice = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(["getAllEvents", "getAllAuthors"])]
    private ?string $eventDesc = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(["getAllEvents", "getAllAuthors"])]
    private ?\DateTimeInterface $eventStartDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(["getAllEvents", "getAllAuthors"])]
    private ?\DateTimeInterface $eventEndDate = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[Groups(["getAllEvents"])]
    private ?Author $author = null;

    #[ORM\Column]
    private ?bool $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventName(): ?string
    {
        return $this->eventName;
    }

    public function setEventName(string $eventName): self
    {
        $this->eventName = $eventName;

        return $this;
    }

    public function getEventPrice(): ?float
    {
        return $this->eventPrice;
    }

    public function setEventPrice(?float $eventPrice): self
    {
        $this->eventPrice = $eventPrice;

        return $this;
    }

    public function getEventDesc(): ?string
    {
        return $this->eventDesc;
    }

    public function setEventDesc(?string $eventDesc): self
    {
        $this->eventDesc = $eventDesc;

        return $this;
    }

    public function getEventStartDate(): ?\DateTimeInterface
    {
        return $this->eventStartDate;
    }

    public function setEventStartDate(\DateTimeInterface $eventStartDate): self
    {
        $this->eventStartDate = $eventStartDate;

        return $this;
    }

    public function getEventEndDate(): ?\DateTimeInterface
    {
        return $this->eventEndDate;
    }

    public function setEventEndDate(?\DateTimeInterface $eventEndDate): self
    {
        $this->eventEndDate = $eventEndDate;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }
}
