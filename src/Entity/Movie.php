<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $creationDate = null;

    #[ORM\ManyToOne(inversedBy: 'movie')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Category $category = null;

    #[ORM\Column(length: 255)]
    private ?string $thumbnail = null;

    /*#[ORM\OneToMany(mappedBy: 'movie', targetEntity: Image::class)]
    private Collection $images;*/

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
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

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }


public function getCategory(): ?Category
{
    return $this->category;
}

public function setCategory(?Category $category): self
{
    $this->category = $category;

    return $this;
}
/*
public function getImages(): Collection
{
    return $this->images;
}

public function addImage(Image $image): self
{
    if (!$this->images->contains($image)) {
        $this->images->add($image);
        $image->setMovie($this);
    }

    return $this;
}

public function removeImage(Image $image): self
{
    if ($this->images->removeElement($image)) {
        // set the owning side to null (unless already changed)
        if ($image->getMovie() === $this) {
            $image->setMovie(null);
        }
    }

    return $this;
}*/

public function getThumbnail(): ?string
{
    return $this->thumbnail;
}

public function setThumbnail(string $thumbnail): self
{
    $this->thumbnail = $thumbnail;

    return $this;
}
}
