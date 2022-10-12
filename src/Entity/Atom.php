<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AtomRepository;
// use Symfony\Component\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Groups;
#[ORM\Entity(repositoryClass: AtomRepository::class)]
class Atom
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getAllAtoms"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getAllAtoms"])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(["getAllAtoms"])]
    private ?string $content = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\ManyToOne(inversedBy: 'atom')]
    #[Groups(["getAllAtoms"])]
    private ?Wizard $wizard = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

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

    public function getWizard(): ?Wizard
    {
        return $this->wizard;
    }

    public function setWizard(?Wizard $wizard): self
    {
        $this->wizard = $wizard;

        return $this;
    }
}
