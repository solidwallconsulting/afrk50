<?php

namespace App\Entity;

use App\Repository\PaymentsPlansRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaymentsPlansRepository::class)
 */
class PaymentsPlans
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
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $stripeID;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="lastBoughtPlanType")
     */
    private $users;

    /**
     * @ORM\Column(type="integer")
     */
    private $allowedListing;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $paypalRenewalPlanID;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $policy;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getStripeID(): ?string
    {
        return $this->stripeID;
    }

    public function setStripeID(?string $stripeID): self
    {
        $this->stripeID = $stripeID;

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
            $user->setLastBoughtPlanType($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getLastBoughtPlanType() === $this) {
                $user->setLastBoughtPlanType(null);
            }
        }

        return $this;
    }

    public function getAllowedListing(): ?int
    {
        return $this->allowedListing;
    }

    public function setAllowedListing(int $allowedListing): self
    {
        $this->allowedListing = $allowedListing;

        return $this;
    }

    public function getPaypalRenewalPlanID(): ?string
    {
        return $this->paypalRenewalPlanID;
    }

    public function setPaypalRenewalPlanID(?string $paypalRenewalPlanID): self
    {
        $this->paypalRenewalPlanID = $paypalRenewalPlanID;

        return $this;
    }

    public function getPolicy(): ?string
    {
        return $this->policy;
    }

    public function setPolicy(string $policy): self
    {
        $this->policy = $policy;

        return $this;
    }
}
