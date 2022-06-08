<?php

namespace App\Entity;

use App\Repository\PictureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PictureRepository::class)]
class Picture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $type = 'property';

    #[ORM\Column(type: 'string', length: 255)]
    private $filename;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $room;

    #[ORM\ManyToOne(targetEntity: Property::class, inversedBy: 'pictures')]
    private $property;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $description;

    #[ORM\ManyToOne(targetEntity: Page::class, inversedBy: 'pictures')]
    private $page;

    #[ORM\ManyToOne(targetEntity: Settings::class, inversedBy: 'landing_slider_picture')]
    private $landing_slider;

    #[ORM\ManyToOne(targetEntity: Page::class, inversedBy: 'section')]
    private $section;

//    public function __toString(){
//        return '<img src="public/uploads/'.$this->getFilename().'"/>';
//    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getRoom(): ?string
    {
        return $this->room;
    }

    public function setRoom(?string $room): self
    {
        $this->room = $room;

        return $this;
    }

    public function getProperty(): ?Property
    {
        return $this->property;
    }

    public function setProperty(?Property $property): self
    {
        $this->property = $property;

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

    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function getLandingSlider(): ?Settings
    {
        return $this->landing_slider;
    }

    public function setLandingSlider(?Settings $landing_slider): self
    {
        $this->landing_slider = $landing_slider;

        return $this;
    }

    public function getSection(): ?Page
    {
        return $this->section;
    }

    public function setSection(?Page $section): self
    {
        $this->section = $section;

        return $this;
    }
}
