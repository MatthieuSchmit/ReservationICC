<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ShowRepository")
 * @ORM\Table(name="shows")
 * @ApiResource(
 *     routePrefix="/v0",
 *     itemOperations={
 *         "getOneShow"={
 *             "route_name"="v0_get_one_show",
 *             "normalization_context"={"groups"={"show"}},
 *             "swagger_context"= {
 *                  "summary"= "Get one show.",
 *                  "description"= "Find one show, with id.",
 *              },
 *         }
 *     },
 *     collectionOperations={
 *         "getAllShows"={
 *             "route_name"="v0_get_all_shows",
 *             "normalization_context"={"groups"={"show"}},
 *             "swagger_context"= {
 *                  "summary"= "Get shows.",
 *                  "description"= "Find all shows.",
 *              },
 *         },
 *     }
 * )
 */
class Show
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"show"})
     * @ApiProperty(
     *     identifier=true,
     *     attributes={
     *         "swagger_context"={
     *             "type"="integer",
     *             "description"="The show's id.",
     *         }
     *     },
     * )
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     * @Groups({"show"})
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "type"="string",
     *             "description"="The show's slug. Unique",
     *         }
     *     },
     * )
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show"})
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "type"="string",
     *             "description"="The show's title.",
     *         }
     *     },
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show"})
     */
    private $poster_url;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"show"})
     */
    private $bookable;

    /**
     * @ORM\Column(type="float")
     * @Groups({"show"})
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location")
     * @Groups({"show"})
     */
    private $location;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Representation", mappedBy="showId", orphanRemoval=true)
     */
    private $representations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ArtistTypeShow", mappedBy="showId", orphanRemoval=true)
     */
    private $artists;

    /**
     * @ORM\Column(type="text")
     * @Groups({"show"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"show"})
     */
    private $coverImage;

    /**
     * @Groups({"show"})
     */
    private $cast;

    // Use in templates
    private $authors;
    private $productors;
    private $actors;
    private $directors;

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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPosterUrl(): ?string
    {
        return $this->poster_url;
    }

    public function setPosterUrl(string $poster_url): self
    {
        $this->poster_url = $poster_url;

        return $this;
    }

    public function getBookable(): ?bool
    {
        return $this->bookable;
    }

    public function setBookable(bool $bookable): self
    {
        $this->bookable = $bookable;

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

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getRepresentations() {
        return $this->representations;
    }

    public function getArtists() {
        return $this->artists;
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

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(string $coverImage): self
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    /**
     * Get all cast
     * @return array [type => Names]
     */
    public function getCast() {
        $cast = [];
        foreach ($this->getArtists() as $artist) {
            $cast[$artist->getArtistType()->getType()->getType()][] =
                $artist->getArtistType()->getArtist()->getFirstname() .
                ' ' . $artist->getArtistType()->getArtist()->getLastname();
        }
        return $cast;
    }

    public function getAuthors() {
        $cast = [];
        foreach ($this->getArtists() as $artist) {
            if ($artist->getArtistType()->getType()->getType() == 'Auteur') {
                $cast[] = $artist->getArtistType()->getArtist()->getFirstname() .
                    ' ' . $artist->getArtistType()->getArtist()->getLastname();
            }
        }
        return $cast;
    }

    public function getProductors() {
        $cast = [];
        foreach ($this->getArtists() as $artist) {
            if ($artist->getArtistType()->getType()->getType() == 'Producteur') {
                $cast[] = $artist->getArtistType()->getArtist()->getFirstname() .
                    ' ' . $artist->getArtistType()->getArtist()->getLastname();
            }
        }
        return $cast;
    }

    public function getActors() {
        $cast = [];
        foreach ($this->getArtists() as $artist) {
            if ($artist->getArtistType()->getType()->getType() == 'Acteur') {
                $cast[] = $artist->getArtistType()->getArtist()->getFirstname() .
                    ' ' . $artist->getArtistType()->getArtist()->getLastname();
            }
        }
        return $cast;
    }

    public function getDirectors() {
        $cast = [];
        foreach ($this->getArtists() as $artist) {
            if ($artist->getArtistType()->getType()->getType() == 'Metteur en scene') {
                $cast[] = $artist->getArtistType()->getArtist()->getFirstname() .
                    ' ' . $artist->getArtistType()->getArtist()->getLastname();
            }
        }
        return $cast;
    }
}
