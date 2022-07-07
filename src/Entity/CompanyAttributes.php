<?php

namespace App\Entity;

use App\Repository\CompanyAttributesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompanyAttributesRepository::class)
 */
class CompanyAttributes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="companyAttributes")
     */
    private $company;

    /**
     * @ORM\ManyToOne(targetEntity=Attributes::class, inversedBy="companyAttributes")
     */
    private $attribute;

    /**
     * @ORM\OneToMany(targetEntity=CompanyAttributesValues::class, mappedBy="selectedCompanyAttribute")
     */
    private $companyAttributesValues;

    public function __construct()
    {
        $this->companyAttributesValues = new ArrayCollection();
    }

 

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAttribute(): ?Attributes
    {
        return $this->attribute;
    }

    public function setAttribute(?Attributes $attribute): self
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * @return Collection|CompanyAttributesValues[]
     */
    public function getCompanyAttributesValues(): Collection
    {
        return $this->companyAttributesValues;
    }

    public function addCompanyAttributesValue(CompanyAttributesValues $companyAttributesValue): self
    {
        if (!$this->companyAttributesValues->contains($companyAttributesValue)) {
            $this->companyAttributesValues[] = $companyAttributesValue;
            $companyAttributesValue->setSelectedCompanyAttribute($this);
        }

        return $this;
    }

    public function removeCompanyAttributesValue(CompanyAttributesValues $companyAttributesValue): self
    {
        if ($this->companyAttributesValues->removeElement($companyAttributesValue)) {
            // set the owning side to null (unless already changed)
            if ($companyAttributesValue->getSelectedCompanyAttribute() === $this) {
                $companyAttributesValue->setSelectedCompanyAttribute(null);
            }
        }

        return $this;
    }

 
}
