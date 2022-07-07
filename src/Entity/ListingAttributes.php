<?php

namespace App\Entity;

use App\Repository\ListingAttributesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ListingAttributesRepository::class)
 */
class ListingAttributes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Listing::class, inversedBy="listingAttributes")
     */
    private $listing;

    /**
     * @ORM\ManyToOne(targetEntity=Attributes::class, inversedBy="listingAttributes")
     */
    private $attribute;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAttribute(): ?Attributes
    {
        return $this->attribute;
    }

    public function setAttribute(?Attributes $attribute): self
    {
        $this->attribute = $attribute;

        return $this;
    }
}
