<?php

namespace App\Entity;

use App\Repository\PropertyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PropertyRepository::class)]
class Property
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 200)]
    private $title;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'integer')]
    private $bedrooms;

    #[ORM\Column(type: 'float')]
    private $min_price;

    #[ORM\Column(type: 'string', length: 50)]
    private $type;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $pool;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $gym;

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

    public function getBedrooms(): ?int
    {
        return $this->bedrooms;
    }

    public function setBedrooms(int $bedrooms): self
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    public function getMinPrice(): ?float
    {
        return $this->min_price;
    }

    public function setMinPrice(float $min_price): self
    {
        $this->min_price = $min_price;

        return $this;
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

    public function getPool(): ?string
    {
        return $this->pool;
    }

    public function setPool(?string $pool): self
    {
        $this->pool = $pool;

        return $this;
    }

    public function getGym(): ?string
    {
        return $this->gym;
    }

    public function setGym(?string $gym): self
    {
        $this->gym = $gym;

        return $this;
    }
}
