<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompanyRepository::class)
 */
class Company
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
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $slogan;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logoURL;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $videoURL;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $timezone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lng;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lat;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $addionalInformations;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=CompanyCategories::class, mappedBy="company")
     */
    private $companyCategories;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $coverImageURL;

    /**
     * @ORM\OneToMany(targetEntity=SocialMedia::class, mappedBy="company")
     */
    private $socialMedia;

    /**
     * @ORM\OneToMany(targetEntity=CompanyWorkingDay::class, mappedBy="company")
     */
    private $companyWorkingDays;

    /**
     * @ORM\OneToMany(targetEntity=CompanyAttributes::class, mappedBy="company")
     */
    private $companyAttributes;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $status;

    //  0 = pending 1 = published 2 waiting for payment 3 expired 4 declined

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="companies")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Listing::class, inversedBy="companies")
     */
    private $listing;

    /**
     * @ORM\OneToMany(targetEntity=Rating::class, mappedBy="company")
     */
    private $ratings;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $avgRating = 0;

    /**
     * @ORM\OneToMany(targetEntity=BookMark::class, mappedBy="company")
     */
    private $bookMarks;

    /**
     * @ORM\OneToMany(targetEntity=PromotionInvoice::class, mappedBy="listing")
     */
    private $promotionInvoices;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $promotedPeriod;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $startPromotionAt;

    /**
     * @ORM\OneToMany(targetEntity=ListingReports::class, mappedBy="listing")
     */
    private $listingReports;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isDeleted;

    public function __construct()
    {
        $this->companyCategories = new ArrayCollection();
        $this->socialMedia = new ArrayCollection();
        $this->companyWorkingDays = new ArrayCollection();
        $this->companyAttributes = new ArrayCollection();
        $this->ratings = new ArrayCollection();
        $this->bookMarks = new ArrayCollection();
        $this->promotionInvoices = new ArrayCollection();
        $this->listingReports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlogan(): ?string
    {
        return $this->slogan;
    }

    public function setSlogan(string $slogan): self
    {
        $this->slogan = $slogan;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getLogoURL(): ?string
    {
        return $this->logoURL;
    }

    public function setLogoURL(?string $logoURL): self
    {
        $this->logoURL = $logoURL;

        return $this;
    }

    public function getVideoURL(): ?string
    {
        return $this->videoURL;
    }

    public function setVideoURL(?string $videoURL): self
    {
        $this->videoURL = $videoURL;

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

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    public function setTimezone(string $timezone): self
    {
        $this->timezone = $timezone;

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

    public function getLng(): ?string
    {
        return $this->lng;
    }

    public function setLng(?string $lng): self
    {
        $this->lng = $lng;

        return $this;
    }

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(?string $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getAddionalInformations(): ?string
    {
        return $this->addionalInformations;
    }

    public function setAddionalInformations(?string $addionalInformations): self
    {
        $this->addionalInformations = $addionalInformations;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|CompanyCategories[]
     */
    public function getCompanyCategories(): Collection
    {
        return $this->companyCategories;
    }

    public function addCompanyCategory(CompanyCategories $companyCategory): self
    {
        if (!$this->companyCategories->contains($companyCategory)) {
            $this->companyCategories[] = $companyCategory;
            $companyCategory->setCompany($this);
        }

        return $this;
    }

    public function removeCompanyCategory(CompanyCategories $companyCategory): self
    {
        if ($this->companyCategories->removeElement($companyCategory)) {
            // set the owning side to null (unless already changed)
            if ($companyCategory->getCompany() === $this) {
                $companyCategory->setCompany(null);
            }
        }

        return $this;
    }

    public function getCoverImageURL(): ?string
    {
        return $this->coverImageURL;
    }

    public function setCoverImageURL(?string $coverImageURL): self
    {
        $this->coverImageURL = $coverImageURL;

        return $this;
    }

    /**
     * @return Collection|SocialMedia[]
     */
    public function getSocialMedia(): Collection
    {
        return $this->socialMedia;
    }

    public function addSocialMedium(SocialMedia $socialMedium): self
    {
        if (!$this->socialMedia->contains($socialMedium)) {
            $this->socialMedia[] = $socialMedium;
            $socialMedium->setCompany($this);
        }

        return $this;
    }

    public function removeSocialMedium(SocialMedia $socialMedium): self
    {
        if ($this->socialMedia->removeElement($socialMedium)) {
            // set the owning side to null (unless already changed)
            if ($socialMedium->getCompany() === $this) {
                $socialMedium->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CompanyWorkingDay[]
     */
    public function getCompanyWorkingDays(): Collection
    {
        return $this->companyWorkingDays;
    }

    public function addCompanyWorkingDay(CompanyWorkingDay $companyWorkingDay): self
    {
        if (!$this->companyWorkingDays->contains($companyWorkingDay)) {
            $this->companyWorkingDays[] = $companyWorkingDay;
            $companyWorkingDay->setCompany($this);
        }

        return $this;
    }

    public function removeCompanyWorkingDay(CompanyWorkingDay $companyWorkingDay): self
    {
        if ($this->companyWorkingDays->removeElement($companyWorkingDay)) {
            // set the owning side to null (unless already changed)
            if ($companyWorkingDay->getCompany() === $this) {
                $companyWorkingDay->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CompanyAttributes[]
     */
    public function getCompanyAttributes(): Collection
    {
        return $this->companyAttributes;
    }

    public function addCompanyAttribute(CompanyAttributes $companyAttribute): self
    {
        if (!$this->companyAttributes->contains($companyAttribute)) {
            $this->companyAttributes[] = $companyAttribute;
            $companyAttribute->setCompany($this);
        }

        return $this;
    }

    public function removeCompanyAttribute(CompanyAttributes $companyAttribute): self
    {
        if ($this->companyAttributes->removeElement($companyAttribute)) {
            // set the owning side to null (unless already changed)
            if ($companyAttribute->getCompany() === $this) {
                $companyAttribute->setCompany(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

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

    public function getListing(): ?Listing
    {
        return $this->listing;
    }

    public function setListing(?Listing $listing): self
    {
        $this->listing = $listing;

        return $this;
    }

    /**
     * @return Collection|Rating[]
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(Rating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setCompany($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        if ($this->ratings->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getCompany() === $this) {
                $rating->setCompany(null);
            }
        }

        return $this;
    }

    public function getAvgRating(): ?float
    {
        return $this->avgRating;
    }

    public function setAvgRating(?float $avgRating): self
    {
        $this->avgRating = $avgRating;

        return $this;
    }

    /**
     * @return Collection|BookMark[]
     */
    public function getBookMarks(): Collection
    {
        return $this->bookMarks;
    }

    public function addBookMark(BookMark $bookMark): self
    {
        if (!$this->bookMarks->contains($bookMark)) {
            $this->bookMarks[] = $bookMark;
            $bookMark->setCompany($this);
        }

        return $this;
    }

    public function removeBookMark(BookMark $bookMark): self
    {
        if ($this->bookMarks->removeElement($bookMark)) {
            // set the owning side to null (unless already changed)
            if ($bookMark->getCompany() === $this) {
                $bookMark->setCompany(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PromotionInvoice[]
     */
    public function getPromotionInvoices(): Collection
    {
        return $this->promotionInvoices;
    }

    public function addPromotionInvoice(PromotionInvoice $promotionInvoice): self
    {
        if (!$this->promotionInvoices->contains($promotionInvoice)) {
            $this->promotionInvoices[] = $promotionInvoice;
            $promotionInvoice->setListing($this);
        }

        return $this;
    }

    public function removePromotionInvoice(PromotionInvoice $promotionInvoice): self
    {
        if ($this->promotionInvoices->removeElement($promotionInvoice)) {
            // set the owning side to null (unless already changed)
            if ($promotionInvoice->getListing() === $this) {
                $promotionInvoice->setListing(null);
            }
        }

        return $this;
    }

    public function getPromotedPeriod(): ?int
    {
        return $this->promotedPeriod;
    }

    public function setPromotedPeriod(?int $promotedPeriod): self
    {
        $this->promotedPeriod = $promotedPeriod;

        return $this;
    }

    public function getStartPromotionAt(): ?\DateTimeInterface
    {
        return $this->startPromotionAt;
    }

    public function setStartPromotionAt(?\DateTimeInterface $startPromotionAt): self
    {
        $this->startPromotionAt = $startPromotionAt;

        return $this;
    }

    /**
     * @return Collection|ListingReports[]
     */
    public function getListingReports(): Collection
    {
        return $this->listingReports;
    }

    public function addListingReport(ListingReports $listingReport): self
    {
        if (!$this->listingReports->contains($listingReport)) {
            $this->listingReports[] = $listingReport;
            $listingReport->setListing($this);
        }

        return $this;
    }

    public function removeListingReport(ListingReports $listingReport): self
    {
        if ($this->listingReports->removeElement($listingReport)) {
            // set the owning side to null (unless already changed)
            if ($listingReport->getListing() === $this) {
                $listingReport->setListing(null);
            }
        }

        return $this;
    }

    public function getIsDeleted(): ?bool
    {
        return $this->isDeleted;
    }

    public function setIsDeleted(?bool $isDeleted): self
    {
        $this->isDeleted = $isDeleted;

        return $this;
    }
}
