<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RepresentationUserRepository")
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * Callback appelé à chaque fois qu'on créé une réservation
     *
     * @ORM\PrePersist
     *
     * @return void
     *
     */
    public function prePersist(){

        if (empty($this->amount)){
            // prix du specatcle * nombre de place
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