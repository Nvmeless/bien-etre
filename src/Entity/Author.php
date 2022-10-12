<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
// use Symfony\Component\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getAllEvents", 'getAllAuthors', "getAllAtoms"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getAllEvents", 'getAllAuthors', "getAllAtoms"])]
    #[Assert\NotBlank(message: "Un auteur doit avoir un nom")]
    #[Assert\NotNull(message: "Un auteur doit avoir un nom")]
    #[Assert\Length(min: 3, minMessage: "Le nom de l'auteur est trop court, on rappelle : au minimum {{ limit }}")]
    private ?string $authorFirstName = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["getAllEvents", 'getAllAuthors', "getAllAtoms"])]
    private ?string $authorLastName = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Event::class)]
    #[Groups(['getAllAuthors'])]
    private Collection $events;

    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthorFirstName(): ?string
    {
        return $this->authorFirstName;
    }

    public function setAuthorFirstName(string $authorFirstName): self
    {
        $this->authorFirstName = $authorFirstName;

        return $this;
    }

    public function getAuthorLastName(): ?string
    {
        return $this->authorLastName;
    }

    public function setAuthorLastName(?string $authorLastName): self
    {
        $this->authorLastName = $authorLastName;

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setAuthor($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getAuthor() === $this) {
                $event->setAuthor(null);
            }
        }

        return $this;
    }
}
