<?php

namespace App\Entity;

use App\Repository\PageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PageRepository::class)]
class Page
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\OneToMany(mappedBy: 'page', targetEntity: Picture::class,cascade: ['persist'])]
    private $pictures;

    #[ORM\OneToOne(targetEntity: Picture::class, cascade: ['persist', 'remove'])]
    private $banner;

    #[ORM\OneToMany(mappedBy: 'section', targetEntity: Picture::class)]
    private $section;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
        $this->section = new ArrayCollection();
    }
    public function __toString() {
        return '';
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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Picture>
     */
    public function getPictures(): Collection
    {
        return $this->pictures;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->pictures->contains($picture)) {
            $this->pictures[] = $picture;
            $picture->setPage($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getPage() === $this) {
                $picture->setPage(null);
            }
        }

        return $this;
    }

    public function getBanner(): ?Picture
    {
        return $this->banner;
    }

    public function setBanner(?Picture $banner): self
    {
        $this->banner = $banner;

        return $this;
    }

    /**
     * @return Collection<int, Picture>
     */
    public function getSection(): Collection
    {
        return $this->section;
    }

    public function addSection(Picture $section): self
    {
        if (!$this->section->contains($section)) {
            $this->section[] = $section;
            $section->setSection($this);
        }

        return $this;
    }

    public function removeSection(Picture $section): self
    {
        if ($this->section->removeElement($section)) {
            // set the owning side to null (unless already changed)
            if ($section->getSection() === $this) {
                $section->setSection(null);
            }
        }

        return $this;
    }
}
