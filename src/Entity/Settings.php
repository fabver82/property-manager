<?php

namespace App\Entity;

use App\Repository\SettingsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SettingsRepository::class)]
class Settings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $logo;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $landing_title;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $landing_text;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $SocialFB;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $socialTwitter;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $socialLinkedIn;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $socialInsta;

    #[ORM\OneToMany(mappedBy: 'landing_slider', targetEntity: Picture::class)]
    private $landing_slider_picture;

    public function __construct()
    {
        $this->landing_slider_picture = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getLandingTitle(): ?string
    {
        return $this->landing_title;
    }

    public function setLandingTitle(?string $landing_title): self
    {
        $this->landing_title = $landing_title;

        return $this;
    }

    public function getLandingText(): ?string
    {
        return $this->landing_text;
    }

    public function setLandingText(?string $landing_text): self
    {
        $this->landing_text = $landing_text;

        return $this;
    }

    public function getSocialFB(): ?string
    {
        return $this->SocialFB;
    }

    public function setSocialFB(?string $SocialFB): self
    {
        $this->SocialFB = $SocialFB;

        return $this;
    }

    public function getSocialTwitter(): ?string
    {
        return $this->socialTwitter;
    }

    public function setSocialTwitter(?string $socialTwitter): self
    {
        $this->socialTwitter = $socialTwitter;

        return $this;
    }

    public function getSocialLinkedIn(): ?string
    {
        return $this->socialLinkedIn;
    }

    public function setSocialLinkedIn(?string $socialLinkedIn): self
    {
        $this->socialLinkedIn = $socialLinkedIn;

        return $this;
    }

    public function getSocialInsta(): ?string
    {
        return $this->socialInsta;
    }

    public function setSocialInsta(?string $socialInsta): self
    {
        $this->socialInsta = $socialInsta;

        return $this;
    }

    /**
     * @return Collection<int, picture>
     */
    public function getLandingSliderPicture(): Collection
    {
        return $this->landing_slider_picture;
    }

    public function addLandingSliderPicture(picture $landingSliderPicture): self
    {
        if (!$this->landing_slider_picture->contains($landingSliderPicture)) {
            $this->landing_slider_picture[] = $landingSliderPicture;
            $landingSliderPicture->setLandingSlider($this);
        }

        return $this;
    }

    public function removeLandingSliderPicture(picture $landingSliderPicture): self
    {
        if ($this->landing_slider_picture->removeElement($landingSliderPicture)) {
            // set the owning side to null (unless already changed)
            if ($landingSliderPicture->getLandingSlider() === $this) {
                $landingSliderPicture->setLandingSlider(null);
            }
        }

        return $this;
    }
}
