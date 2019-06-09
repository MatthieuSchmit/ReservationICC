<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 * @ApiResource(
 *     routePrefix="/v0",
 *     itemOperations={"get"},
 *     collectionOperations={}
 * )
 */
class Location
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=60)
     * @Groups({"show"})
     */
    private $designation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show"})
     */
    private $address;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Locality", inversedBy="locations")
     */
    private $locality;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"show"})
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     * @Groups({"show"})
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show"})
     */
    private $coverImage;

    /**
     * @Groups({"show"})
     * @var $city String 'PostCode City'
     */
    private $city;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getLocality(): ?Locality
    {
        return $this->locality;
    }

    public function setLocality(?Locality $locality): self
    {
        $this->locality = $locality;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(string $coverImage): self
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    public function getCity() {
        return $this->getLocality()->getPostalCode() . ' ' . $this->getLocality()->getLocality();
    }
}
