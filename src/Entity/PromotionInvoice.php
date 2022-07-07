<?php

namespace App\Entity;

use App\Repository\PromotionInvoiceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PromotionInvoiceRepository::class)
 */
class PromotionInvoice
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
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $companyName;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="promotionInvoices")
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $streetAddressOne;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $streetAddressTwo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Town;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $State;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $postcode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $additionalInformation;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="promotionInvoices")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="promotionInvoices")
     */
    private $listing;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getStreetAddressOne(): ?string
    {
        return $this->streetAddressOne;
    }

    public function setStreetAddressOne(string $streetAddressOne): self
    {
        $this->streetAddressOne = $streetAddressOne;

        return $this;
    }

    public function getStreetAddressTwo(): ?string
    {
        return $this->streetAddressTwo;
    }

    public function setStreetAddressTwo(?string $streetAddressTwo): self
    {
        $this->streetAddressTwo = $streetAddressTwo;

        return $this;
    }

    public function getTown(): ?string
    {
        return $this->Town;
    }

    public function setTown(string $Town): self
    {
        $this->Town = $Town;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->State;
    }

    public function setState(string $State): self
    {
        $this->State = $State;

        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(string $postcode): self
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAdditionalInformation(): ?string
    {
        return $this->additionalInformation;
    }

    public function setAdditionalInformation(?string $additionalInformation): self
    {
        $this->additionalInformation = $additionalInformation;

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

    public function getListing(): ?Company
    {
        return $this->listing;
    }

    public function setListing(?Company $listing): self
    {
        $this->listing = $listing;

        return $this;
    }
}
