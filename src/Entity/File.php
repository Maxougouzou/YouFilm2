<?php

namespace App\Entity;

use App\Repository\FileRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FileRepository::class)]
class File
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $path = null;

    #[ORM\Column(length: 255)]
    private ?string $originalName = null;


    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToOne(mappedBy: 'content', cascade: ['persist', 'remove'])]
    private ?Movie $movie = null;

    #[ORM\OneToOne(mappedBy: 'thumbail', cascade: ['persist', 'remove'])]
    private ?Movie $thumbnail = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    public function setOriginalName(?string $originalName): void
    {
        $this->originalName = $originalName;
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

    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

    public function setMovie(Movie $movie): self
    {
        // set the owning side of the relation if necessary
        if ($movie->getContent() !== $this) {
            $movie->setContent($this);
        }

        $this->movie = $movie;

        return $this;
    }

    public function getThumbnail(): ?Movie
    {
        return $this->thumbnail;
    }

    public function setThumbnail(Movie $thumbnail): self
    {
        // set the owning side of the relation if necessary
        if ($thumbnail->getThumbail() !== $this) {
            $thumbnail->setThumbail($this);
        }

        $this->thumbnail = $thumbnail;

        return $this;
    }
}
