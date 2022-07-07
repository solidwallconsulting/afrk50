<?php

namespace App\Entity;

use App\Repository\AttributeValuesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AttributeValuesRepository::class)
 */
class AttributeValues
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
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=Attributes::class, inversedBy="attributeValues")
     */
    private $attribute;

    /**
     * @ORM\OneToMany(targetEntity=CompanyAttributesValues::class, mappedBy="value")
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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

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
            $companyAttributesValue->setValue($this);
        }

        return $this;
    }

    public function removeCompanyAttributesValue(CompanyAttributesValues $companyAttributesValue): self
    {
        if ($this->companyAttributesValues->removeElement($companyAttributesValue)) {
            // set the owning side to null (unless already changed)
            if ($companyAttributesValue->getValue() === $this) {
                $companyAttributesValue->setValue(null);
            }
        }

        return $this;
    }

 
 
 

    
}
