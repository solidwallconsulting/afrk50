<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
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
     * @ORM\ManyToOne(targetEntity=Listing::class, inversedBy="categories")
     */
    private $listing;

    /**
     * @ORM\OneToMany(targetEntity=CompanyCategories::class, mappedBy="category")
     */
    private $companyCategories;

    public function __construct()
    {
        $this->companyCategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    



    public function __toString()
    {
        return $this->name;
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
            $companyCategory->setCategory($this);
        }

        return $this;
    }

    public function removeCompanyCategory(CompanyCategories $companyCategory): self
    {
        if ($this->companyCategories->removeElement($companyCategory)) {
            // set the owning side to null (unless already changed)
            if ($companyCategory->getCategory() === $this) {
                $companyCategory->setCategory(null);
            }
        }

        return $this;
    }
}
