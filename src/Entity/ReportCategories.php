<?php

namespace App\Entity;

use App\Repository\ReportCategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReportCategoriesRepository::class)
 */
class ReportCategories
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
    private $title;

    /**
     * @ORM\OneToMany(targetEntity=ListingReports::class, mappedBy="category")
     */
    private $listingReports;

    public function __construct()
    {
        $this->listingReports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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
            $listingReport->setCategory($this);
        }

        return $this;
    }

    public function removeListingReport(ListingReports $listingReport): self
    {
        if ($this->listingReports->removeElement($listingReport)) {
            // set the owning side to null (unless already changed)
            if ($listingReport->getCategory() === $this) {
                $listingReport->setCategory(null);
            }
        }

        return $this;
    }
}
