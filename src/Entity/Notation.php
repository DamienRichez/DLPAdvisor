<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NotationRepository")
 */
class Notation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="string", length=1200, nullable=true)
     */
    private $avis;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Attractions", inversedBy="notations")
     */
    private $idAttractions;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="notations")
     */
    private $idUser;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Restaurant", inversedBy="notations")
     */
    private $restaurant;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Soiree", inversedBy="notation")
     */
    private $soiree;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Hotel", inversedBy="Notation")
     */
    private $hotel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getAvis(): ?string
    {
        return $this->avis;
    }

    public function setAvis(?string $avis): self
    {
        $this->avis = $avis;

        return $this;
    }

    public function getIdAttractions(): ?Attractions
    {
        return $this->idAttractions;
    }

    public function setIdAttractions(?Attractions $idAttractions): self
    {
        $this->idAttractions = $idAttractions;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant(?Restaurant $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    public function getSoiree(): ?Soiree
    {
        return $this->soiree;
    }

    public function setSoiree(?Soiree $soiree): self
    {
        $this->soiree = $soiree;

        return $this;
    }

    public function getHotel(): ?Hotel
    {
        return $this->hotel;
    }

    public function setHotel(?Hotel $hotel): self
    {
        $this->hotel = $hotel;

        return $this;
    }
}
