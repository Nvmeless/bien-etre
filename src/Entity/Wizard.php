<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\WizardRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: WizardRepository::class)]
class Wizard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getAllAtoms"])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["getAllAtoms"])]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\OneToMany(mappedBy: 'wizard', targetEntity: Atom::class)]
    private Collection $atom;

    #[ORM\ManyToMany(targetEntity: Picture::class)]
    #[Groups(["getAllAtoms"])]
    private Collection $picture;

    #[ORM\ManyToMany(targetEntity: Event::class)]
    #[Groups(["getAllAtoms"])]
    private Collection $event;

    #[ORM\ManyToMany(targetEntity: Author::class)]
    #[Groups(["getAllAtoms"])]
    private Collection $author;

    public function __construct()
    {
        $this->atom = new ArrayCollection();
        $this->picture = new ArrayCollection();
        $this->event = new ArrayCollection();
        $this->author = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    /**
     * @return Collection<int, Atom>
     */
    public function getAtom(): Collection
    {
        return $this->atom;
    }

    public function addAtom(Atom $atom): self
    {
        if (!$this->atom->contains($atom)) {
            $this->atom->add($atom);
            $atom->setWizard($this);
        }

        return $this;
    }

    public function removeAtom(Atom $atom): self
    {
        if ($this->atom->removeElement($atom)) {
            // set the owning side to null (unless already changed)
            if ($atom->getWizard() === $this) {
                $atom->setWizard(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Picture>
     */
    public function getPicture(): Collection
    {
        return $this->picture;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->picture->contains($picture)) {
            $this->picture->add($picture);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        $this->picture->removeElement($picture);

        return $this;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEvent(): Collection
    {
        return $this->event;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->event->contains($event)) {
            $this->event->add($event);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        $this->event->removeElement($event);

        return $this;
    }

    /**
     * @return Collection<int, Author>
     */
    public function getAuthor(): Collection
    {
        return $this->author;
    }

    public function addAuthor(Author $author): self
    {
        if (!$this->author->contains($author)) {
            $this->author->add($author);
        }

        return $this;
    }

    public function removeAuthor(Author $author): self
    {
        $this->author->removeElement($author);

        return $this;
    }
}
