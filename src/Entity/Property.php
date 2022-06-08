<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\PropertyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PropertyRepository::class)]
class Property
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 200)]
    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 5,
     *      max = 200,
     *      minMessage = "Your title must be at least {{ limit }} characters long",
     *      maxMessage = "Your title cannot be longer than {{ limit }} characters"
     * )
     */
    private $title;

    #[ORM\Column(type: 'text')]
    /**
     * @Assert\NotBlank
     */
    private $description;

    #[ORM\Column(type: 'integer')]
    /**
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Assert\Positive
     */
    private $bedrooms;

    #[ORM\Column(type: 'float')]
    private $min_price;

    #[ORM\Column(type: 'string', length: 50)]
    private $type;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $pool;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $gym;

    #[ORM\OneToMany(mappedBy: 'property', targetEntity: Picture::class,cascade: ['persist'])]
    private $pictures;

    #[ORM\OneToMany(mappedBy: 'property', targetEntity: Booking::class)]
    private $bookings;

    #[ORM\OneToMany(mappedBy: 'property', targetEntity: Price::class)]
    #[ORM\OrderBy(["start_date" => "ASC"])]
    private $prices;

    #[ORM\OneToOne(targetEntity: Picture::class, cascade: ['persist', 'remove'])]
    private $main_picture;

    public function __construct()
    {
        $this->pictures = new ArrayCollection();
        $this->bookings = new ArrayCollection();
        $this->prices = new ArrayCollection();
    }
    public function __toString()
    {
        return $this->title;
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
            $picture->setProperty($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getProperty() === $this) {
                $picture->setProperty(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setProperty($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getProperty() === $this) {
                $booking->setProperty(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Price>
     */
    public function getPrices(): Collection
    {
        return $this->prices;
    }

    public function addPrice(Price $price): self
    {
        if (!$this->prices->contains($price)) {
            $this->prices[] = $price;
            $price->setProperty($this);
        }

        return $this;
    }

    public function removePrice(Price $price): self
    {
        if ($this->prices->removeElement($price)) {
            // set the owning side to null (unless already changed)
            if ($price->getProperty() === $this) {
                $price->setProperty(null);
            }
        }

        return $this;
    }

    public function getMainPicture(): ?Picture
    {
        return $this->main_picture;
    }

    public function setMainPicture(?Picture $main_picture): self
    {
        $this->main_picture = $main_picture;

        return $this;
    }
}
