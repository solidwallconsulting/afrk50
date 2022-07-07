<?php

namespace App\Entity;

use App\Repository\StudentInfoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StudentInfoRepository::class)
 */
class StudentInfo
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
    private $etablismentName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etablismentAddress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $studyDomaine;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $studyStartYear;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $intrestsAreas = [];

 
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $moreInfo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $socialLink;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="studentInfo", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $studentPass;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtablismentName(): ?string
    {
        return $this->etablismentName;
    }

    public function setEtablismentName(string $etablismentName): self
    {
        $this->etablismentName = $etablismentName;

        return $this;
    }

    public function getEtablismentAddress(): ?string
    {
        return $this->etablismentAddress;
    }

    public function setEtablismentAddress(string $etablismentAddress): self
    {
        $this->etablismentAddress = $etablismentAddress;

        return $this;
    }

    public function getStudyDomaine(): ?string
    {
        return $this->studyDomaine;
    }

    public function setStudyDomaine(string $studyDomaine): self
    {
        $this->studyDomaine = $studyDomaine;

        return $this;
    }

    public function getStudyStartYear(): ?string
    {
        return $this->studyStartYear;
    }

    public function setStudyStartYear(string $studyStartYear): self
    {
        $this->studyStartYear = $studyStartYear;

        return $this;
    }

    public function getIntrestsAreas(): ?array
    {
        return $this->intrestsAreas;
    }

    public function setIntrestsAreas(?array $intrestsAreas): self
    {
        $this->intrestsAreas = $intrestsAreas;

        return $this;
    }

 

    public function getMoreInfo(): ?string
    {
        return $this->moreInfo;
    }

    public function setMoreInfo(string $moreInfo): self
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

    public function getStudentPass(): ?string
    {
        return $this->studentPass;
    }

    public function setStudentPass(?string $studentPass): self
    {
        $this->studentPass = $studentPass;

        return $this;
    }
}
