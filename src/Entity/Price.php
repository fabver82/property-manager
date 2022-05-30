<?php

namespace App\Entity;

use App\Repository\PriceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PriceRepository::class)]
class Price
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 5,
     *      max = 200,
     *      minMessage = "Your price name must be at least {{ limit }} characters long",
     *      maxMessage = "Your price name cannot be longer than {{ limit }} characters"
     * )
     */
    private $name;

    #[ORM\Column(type: 'date')]
    /**
     * @Assert\NotNull
     * @Assert\Range(
     *      min = "now",
     *      max = "+1 years"
     * )
     */
    private $start_date;

    #[ORM\Column(type: 'date')]
    /**
     * @Assert\NotNull
     * @Assert\Expression(
     *     "this.getEndDate() >= this.getStartDate()",
     *     message="This value couldn't be before start date"
     * )
     */
    private $end_date;

    #[ORM\Column(type: 'float')]
    /**
     * @Assert\Positive
     */
    private $price;

    #[ORM\ManyToOne(targetEntity: Property::class, inversedBy: 'prices')]
    #[ORM\JoinColumn(nullable: false)]
    private $property;

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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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
}
