<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CountryRepository::class)
 */
class Country
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
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="country")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=PromotionInvoice::class, mappedBy="country")
     */
    private $promotionInvoices;

 

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->promotionInvoices = new ArrayCollection(); 
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
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setCountry($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCountry() === $this) {
                $user->setCountry(null);
            }
        }

        return $this;
    }

 
    public function __toString(){
        return $this->name;
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
            $promotionInvoice->setCountry($this);
        }

        return $this;
    }

    public function removePromotionInvoice(PromotionInvoice $promotionInvoice): self
    {
        if ($this->promotionInvoices->removeElement($promotionInvoice)) {
            // set the owning side to null (unless already changed)
            if ($promotionInvoice->getCountry() === $this) {
                $promotionInvoice->setCountry(null);
            }
        }

        return $this;
    }

   
 

    
}
