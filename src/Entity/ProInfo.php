<?php

namespace App\Entity;

use App\Repository\ProInfoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProInfoRepository::class)
 */
class ProInfo
{
        /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $areasOfExperience;

    /**
     * @ORM\Column(type="integer")
     */
    private $yearsOfExperience;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $areasOfIntrests = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $resumeFILE;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $moreInfo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $socialLink;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="proInfo", cascade={"persist", "remove"})
     */
    private $user;

 
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAreasOfExperience(): ?string
    {
        return $this->areasOfExperience;
    }

    public function setAreasOfExperience(string $areasOfExperience): self
    {
        $this->areasOfExperience = $areasOfExperience;

        return $this;
    }

    public function getYearsOfExperience(): ?int
    {
        return $this->yearsOfExperience;
    }

    public function setYearsOfExperience(int $yearsOfExperience): self
    {
        $this->yearsOfExperience = $yearsOfExperience;

        return $this;
    }

    public function getAreasOfIntrests(): ?array
    {
        return $this->areasOfIntrests;
    }

    public function setAreasOfIntrests(?array $areasOfIntrests): self
    {
        $this->areasOfIntrests = $areasOfIntrests;

        return $this;
    }

    public function getResumeFILE(): ?string
    {
        return $this->resumeFILE;
    }

    public function setResumeFILE(?string $resumeFILE): self
    {
        $this->resumeFILE = $resumeFILE;

        return $this;
    }

    public function getMoreInfo(): ?string
    {
        return $this->moreInfo;
    }

    public function setMoreInfo(?string $moreInfo): self
    {
        $this->moreInfo = $moreInfo;

        return $this;
    }

    public function getSocialLink(): ?string
    {
        return $this->socialLink;
    }

    public function setSocialLink(string $socialLink): self
    {
        $this->socialLink = $socialLink;

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
 
}
