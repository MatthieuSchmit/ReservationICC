<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RepresentationUserRepository")
 */
class RepresentationUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Representation")
     * @ORM\JoinColumn(nullable=false)
     */
    private $representation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="representations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    public $seat;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    public function prePersist(){
        if(empty($this->createdAt)){
            $this->createdAt = new \DateTime();
        }

        if (empty($this->amount)){
            // prix de l'annonce * nombre de jour
            $this->amount = $this->representation->showId->getPrice() * $this->getPlace();
        }
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRepresentation(): ?Representation
    {
        return $this->representation;
    }

    public function setRepresentation(?Representation $representation): self
    {
        $this->representation = $representation;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPlace(): ?int
    {
        return $this->seat;
    }

    public function setPlace(int $seat): self
    {
        $this->seat = $seat;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}
