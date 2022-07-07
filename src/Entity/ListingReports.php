<?php

namespace App\Entity;

use App\Repository\ListingReportsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ListingReportsRepository::class)
 */
class ListingReports
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $reportDate;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="listingReports")
     */
    private $listing;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="listingReports")
     */
    private $reporter;

    /**
     * @ORM\ManyToOne(targetEntity=ReportCategories::class, inversedBy="listingReports")
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getReportDate(): ?\DateTimeInterface
    {
        return $this->reportDate;
    }

    public function setReportDate(\DateTimeInterface $reportDate): self
    {
        $this->reportDate = $reportDate;

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

    public function getReporter(): ?User
    {
        return $this->reporter;
    }

    public function setReporter(?User $reporter): self
    {
        $this->reporter = $reporter;

        return $this;
    }

    public function getCategory(): ?ReportCategories
    {
        return $this->category;
    }

    public function setCategory(?ReportCategories $category): self
    {
        $this->category = $category;

        return $this;
    }
}
