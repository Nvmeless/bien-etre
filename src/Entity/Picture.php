<?php

namespace App\Entity;

use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Repository\PictureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PictureRepository::class)]
/**
 * @Vich\Uploadable()
 */
class Picture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getPictures"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getPictures"])]
    private ?string $realname = null;

    #[ORM\Column(length: 255)]
    private ?string $realpath = null;

    #[ORM\Column(length: 255)]
    private ?string $publicPath = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getPictures"])]
    private ?string $mime = null;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="pictures",fileNameProperty="realpath")
     */
    private $file;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $uploadDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRealname(): ?string
    {
        return $this->realname;
    }

    public function setRealname(string $realname): self
    {
        $this->realname = $realname;

        return $this;
    }

    public function getRealpath(): ?string
    {
        return $this->realpath;
    }

    public function setRealpath(string $realpath): self
    {
        $this->realpath = $realpath;

        return $this;
    }

    public function getPublicPath(): ?string
    {
        return $this->publicPath;
    }

    public function setPublicPath(string $publicPath): self
    {
        $this->publicPath = $publicPath;

        return $this;
    }

    public function getMime(): ?string
    {
        return $this->mime;
    }

    public function setMime(string $mime): self
    {
        $this->mime = $mime;

        return $this;
    }

    public function getFile(): ?File 
    {
        return $this->file;
    }
    
    public function setFile(?File $file): ?Picture 
    {
        $this->file = $file;
        return $this;
    }


    public function getUploadDate(): ?\DateTimeInterface
    {
        return $this->uploadDate;
    }

    public function setUploadDate(\DateTimeInterface $uploadDate): self
    {
        $this->uploadDate = $uploadDate;

        return $this;
    }
}
