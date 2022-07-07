<?php

namespace App\Entity;

use App\Repository\RatingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RatingRepository::class)
 */
class Rating
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $overall = 0;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $hospitality = 0;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $services = 0;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $pricing = 0;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $joinedImageURL;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $review;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ratings")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="ratings")
     */
    private $company;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $average;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOverall(): ?float
    {
        return $this->overall;
    }

    public function setOverall(?float $overall): self
    {
        $this->overall = $overall;

        return $this;
    }

    public function getHospitality(): ?float
    {
        return $this->hospitality;
    }

    public function setHospitality(?float $hospitality): self
    {
        $this->hospitality = $hospitality;

        return $this;
    }

    public function getServices(): ?float
    {
        return $this->services;
    }

    public function setServices(?float $services): self
    {
        $this->services = $services;

        return $this;
    }

    public function getPricing(): ?float
    {
        return $this->pricing;
    }

    public function setPricing(?float $pricing): self
    {
        $this->pricing = $pricing;

        return $this;
    }

    public function getJoinedImageURL(): ?string
    {
        return $this->joinedImageURL;
    }

    public function setJoinedImageURL(?string $joinedImageURL): self
    {
        $this->joinedImageURL = $joinedImageURL;

        return $this;
    }

    public function getReview(): ?string
    {
        return $this->review;
    }

    public function setReview(?string $review): self
    {
        $this->review = $review;

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

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAverage(): ?float
    {
        return $this->average;
    }

    public function setAverage(?float $average): self
    {
        $this->average = $average;

        return $this;
    }
}
