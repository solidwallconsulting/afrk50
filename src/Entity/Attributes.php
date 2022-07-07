<?php

namespace App\Entity;

use App\Repository\AttributesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AttributesRepository::class)
 */
class Attributes
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
     * @ORM\OneToMany(targetEntity=AttributeValues::class, mappedBy="attribute")
     */
    private $attributeValues;

    /**
     * @ORM\OneToMany(targetEntity=AttributeCategory::class, mappedBy="attribute")
     */
    private $attributeCategories;

    /**
     * @ORM\OneToMany(targetEntity=ListingAttributes::class, mappedBy="attribute")
     */
    private $listingAttributes;

    /**
     * @ORM\OneToMany(targetEntity=CompanyAttributes::class, mappedBy="attribute")
     */
    private $companyAttributes;

 

    public function __construct()
    {
        $this->attributeValues = new ArrayCollection();
        $this->attributeCategories = new ArrayCollection();
        $this->listingAttributes = new ArrayCollection();
        $this->companyAttributes = new ArrayCollection();
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

    /**
     * @return Collection|AttributeValues[]
     */
    public function getAttributeValues(): Collection
    {
        return $this->attributeValues;
    }

    public function addAttributeValue(AttributeValues $attributeValue): self
    {
        if (!$this->attributeValues->contains($attributeValue)) {
            $this->attributeValues[] = $attributeValue;
            $attributeValue->setAttribute($this);
        }

        return $this;
    }

    public function removeAttributeValue(AttributeValues $attributeValue): self
    {
        if ($this->attributeValues->removeElement($attributeValue)) {
            // set the owning side to null (unless already changed)
            if ($attributeValue->getAttribute() === $this) {
                $attributeValue->setAttribute(null);
            }
        }

        return $this;
    }


    public function __toString() 
    {
        return $this->name;
    }

    /**
     * @return Collection|AttributeCategory[]
     */
    public function getAttributeCategories(): Collection
    {
        return $this->attributeCategories;
    }

    public function addAttributeCategory(AttributeCategory $attributeCategory): self
    {
        if (!$this->attributeCategories->contains($attributeCategory)) {
            $this->attributeCategories[] = $attributeCategory;
            $attributeCategory->setAttribute($this);
        }

        return $this;
    }

    public function removeAttributeCategory(AttributeCategory $attributeCategory): self
    {
        if ($this->attributeCategories->removeElement($attributeCategory)) {
            // set the owning side to null (unless already changed)
            if ($attributeCategory->getAttribute() === $this) {
                $attributeCategory->setAttribute(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ListingAttributes[]
     */
    public function getListingAttributes(): Collection
    {
        return $this->listingAttributes;
    }

    public function addListingAttribute(ListingAttributes $listingAttribute): self
    {
        if (!$this->listingAttributes->contains($listingAttribute)) {
            $this->listingAttributes[] = $listingAttribute;
            $listingAttribute->setAttribute($this);
        }

        return $this;
    }

    public function removeListingAttribute(ListingAttributes $listingAttribute): self
    {
        if ($this->listingAttributes->removeElement($listingAttribute)) {
            // set the owning side to null (unless already changed)
            if ($listingAttribute->getAttribute() === $this) {
                $listingAttribute->setAttribute(null);
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
            $companyAttribute->setAttribute($this);
        }

        return $this;
    }

    public function removeCompanyAttribute(CompanyAttributes $companyAttribute): self
    {
        if ($this->companyAttributes->removeElement($companyAttribute)) {
            // set the owning side to null (unless already changed)
            if ($companyAttribute->getAttribute() === $this) {
                $companyAttribute->setAttribute(null);
            }
        }

        return $this;
    }


 
 
}
