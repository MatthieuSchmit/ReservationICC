<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\ArtistTypeShowRepository")
 */
class ArtistTypeShow
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ArtistType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $artistType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Show")
     * @ORM\JoinColumn(nullable=false)
     */
    private $showId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArtistType(): ?ArtistType
    {
        return $this->artistType;
    }

    public function setArtistType(?ArtistType $artistType): self
    {
        $this->artistType = $artistType;

        return $this;
    }

    public function getShowId(): ?Show
    {
        return $this->showId;
    }

    public function setShowId(?Show $showId): self
    {
        $this->showId = $showId;

        return $this;
    }
}
