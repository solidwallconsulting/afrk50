<?php

namespace App\Entity;

use App\Repository\CompanyAttributesValuesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompanyAttributesValuesRepository::class)
 */
class CompanyAttributesValues
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=AttributeValues::class, inversedBy="companyAttributesValues")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=CompanyAttributes::class, inversedBy="companyAttributesValues")
     */
    private $selectedCompanyAttribute;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?AttributeValues
    {
        return $this->value;
    }

    public function setValue(?AttributeValues $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getSelectedCompanyAttribute(): ?CompanyAttributes
    {
        return $this->selectedCompanyAttribute;
    }

    public function setSelectedCompanyAttribute(?CompanyAttributes $selectedCompanyAttribute): self
    {
        $this->selectedCompanyAttribute = $selectedCompanyAttribute;

        return $this;
    }
}
