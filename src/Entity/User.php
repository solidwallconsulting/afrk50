<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection; 
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photoURL;
 

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isBlocked;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $resetPasswordToken;

 

    /**
     * @ORM\OneToMany(targetEntity=Company::class, mappedBy="user")
     */
    private $companies;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $boughtDays;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $signupDate;

    /**
     * @ORM\OneToMany(targetEntity=Rating::class, mappedBy="user")
     */
    private $ratings;

    /**
     * @ORM\OneToMany(targetEntity=BookMark::class, mappedBy="user")
     */
    private $bookMarks;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="users")
     */
    private $country;

    /**
     * @ORM\OneToMany(targetEntity=PromotionInvoice::class, mappedBy="user")
     */
    private $promotionInvoices;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $privacy;

    /**
     * @ORM\OneToMany(targetEntity=ListingReports::class, mappedBy="reporter")
     */
    private $listingReports;

    /**
     * @ORM\OneToMany(targetEntity=DirectMessages::class, mappedBy="sender")
     */
    private $directMessages;

    /**
     * @ORM\OneToMany(targetEntity=ChatMessages::class, mappedBy="sender")
     */
    private $chatMessages;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $fcm;

    /**
     * @ORM\OneToMany(targetEntity=HowItHelps::class, mappedBy="user")
     */
    private $howItHelps;

    /**
     * @ORM\ManyToOne(targetEntity=PaymentsPlans::class, inversedBy="users")
     */
    private $lastBoughtPlanType;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $displayName;

    /**
     * @ORM\ManyToOne(targetEntity=UserCategories::class, inversedBy="users")
     */
    private $category;

    /**
     * @ORM\OneToOne(targetEntity=StudentInfo::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $studentInfo;

    /**
     * @ORM\OneToOne(targetEntity=JobSeekerInfo::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $jobSeekerInfo;

    /**
     * @ORM\OneToOne(targetEntity=ProInfo::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $proInfo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $coverURL;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $about;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isVerified;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $verificationToken;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $physicalAddress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $yearOfCreation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $numberOfEmployees;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $rangeOfYearlyRevenues;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $typeOfCompany;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phaseOfTheCompany;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $registrationNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contactPerson;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $shortCompanyDescription;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $interests;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyName;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isLeagalEntity;


    

   

 

    public function __construct()
    {
        $this->companies = new ArrayCollection();
        $this->ratings = new ArrayCollection();
        $this->bookMarks = new ArrayCollection();
        $this->promotionInvoices = new ArrayCollection();
        $this->listingReports = new ArrayCollection();
        $this->directMessages = new ArrayCollection();
        $this->chatMessages = new ArrayCollection();
        $this->howItHelps = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhotoURL(): ?string
    {
        return $this->photoURL;
    }

    public function setPhotoURL(string $photoURL): self
    {
        $this->photoURL = $photoURL;

        return $this;
    }

     
  

    public function getIsBlocked(): ?bool
    {
        return $this->isBlocked;
    }

    public function setIsBlocked(?bool $isBlocked): self
    {
        $this->isBlocked = $isBlocked;

        return $this;
    }

    public function getResetPasswordToken(): ?string
    {
        return $this->resetPasswordToken;
    }

    public function setResetPasswordToken(?string $resetPasswordToken): self
    {
        $this->resetPasswordToken = $resetPasswordToken;

        return $this;
    }

 

    /**
     * @return Collection|Company[]
     */
    public function getCompanies(): Collection
    {
        return $this->companies;
    }

    public function addCompany(Company $company): self
    {
        if (!$this->companies->contains($company)) {
            $this->companies[] = $company;
            $company->setUser($this);
        }

        return $this;
    }

    public function removeCompany(Company $company): self
    {
        if ($this->companies->removeElement($company)) {
            // set the owning side to null (unless already changed)
            if ($company->getUser() === $this) {
                $company->setUser(null);
            }
        }

        return $this;
    }

    public function getBoughtDays(): ?int
    {
        return $this->boughtDays;
    }

    public function setBoughtDays(?int $boughtDays): self
    {
        $this->boughtDays = $boughtDays;

        return $this;
    }

    public function getSignupDate(): ?\DateTimeInterface
    {
        return $this->signupDate;
    }

    public function setSignupDate(?\DateTimeInterface $signupDate): self
    {
        $this->signupDate = $signupDate;

        return $this;
    }

    /**
     * @return Collection|Rating[]
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(Rating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setUser($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        if ($this->ratings->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getUser() === $this) {
                $rating->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BookMark[]
     */
    public function getBookMarks(): Collection
    {
        return $this->bookMarks;
    }

    public function addBookMark(BookMark $bookMark): self
    {
        if (!$this->bookMarks->contains($bookMark)) {
            $this->bookMarks[] = $bookMark;
            $bookMark->setUser($this);
        }

        return $this;
    }

    public function removeBookMark(BookMark $bookMark): self
    {
        if ($this->bookMarks->removeElement($bookMark)) {
            // set the owning side to null (unless already changed)
            if ($bookMark->getUser() === $this) {
                $bookMark->setUser(null);
            }
        }

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
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
            $promotionInvoice->setUser($this);
        }

        return $this;
    }

    public function removePromotionInvoice(PromotionInvoice $promotionInvoice): self
    {
        if ($this->promotionInvoices->removeElement($promotionInvoice)) {
            // set the owning side to null (unless already changed)
            if ($promotionInvoice->getUser() === $this) {
                $promotionInvoice->setUser(null);
            }
        }

        return $this;
    }

    public function getPrivacy(): ?int
    {
        return $this->privacy;
    }

    public function setPrivacy(?int $privacy): self
    {
        $this->privacy = $privacy;

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
            $listingReport->setReporter($this);
        }

        return $this;
    }

    public function removeListingReport(ListingReports $listingReport): self
    {
        if ($this->listingReports->removeElement($listingReport)) {
            // set the owning side to null (unless already changed)
            if ($listingReport->getReporter() === $this) {
                $listingReport->setReporter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DirectMessages[]
     */
    public function getDirectMessages(): Collection
    {
        return $this->directMessages;
    }

    public function addDirectMessage(DirectMessages $directMessage): self
    {
        if (!$this->directMessages->contains($directMessage)) {
            $this->directMessages[] = $directMessage;
            $directMessage->setSender($this);
        }

        return $this;
    }

    public function removeDirectMessage(DirectMessages $directMessage): self
    {
        if ($this->directMessages->removeElement($directMessage)) {
            // set the owning side to null (unless already changed)
            if ($directMessage->getSender() === $this) {
                $directMessage->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ChatMessages[]
     */
    public function getChatMessages(): Collection
    {
        return $this->chatMessages;
    }

    public function addChatMessage(ChatMessages $chatMessage): self
    {
        if (!$this->chatMessages->contains($chatMessage)) {
            $this->chatMessages[] = $chatMessage;
            $chatMessage->setSender($this);
        }

        return $this;
    }

    public function removeChatMessage(ChatMessages $chatMessage): self
    {
        if ($this->chatMessages->removeElement($chatMessage)) {
            // set the owning side to null (unless already changed)
            if ($chatMessage->getSender() === $this) {
                $chatMessage->setSender(null);
            }
        }

        return $this;
    }

    public function getFcm(): ?string
    {
        return $this->fcm;
    }

    public function setFcm(?string $fcm): self
    {
        $this->fcm = $fcm;

        return $this;
    }

    /**
     * @return Collection|HowItHelps[]
     */
    public function getHowItHelps(): Collection
    {
        return $this->howItHelps;
    }

    public function addHowItHelp(HowItHelps $howItHelp): self
    {
        if (!$this->howItHelps->contains($howItHelp)) {
            $this->howItHelps[] = $howItHelp;
            $howItHelp->setUser($this);
        }

        return $this;
    }

    public function removeHowItHelp(HowItHelps $howItHelp): self
    {
        if ($this->howItHelps->removeElement($howItHelp)) {
            // set the owning side to null (unless already changed)
            if ($howItHelp->getUser() === $this) {
                $howItHelp->setUser(null);
            }
        }

        return $this;
    }



 
    public function __toString()
    {
        return  $this->firstname.' '.$this->lastname;
    }

    public function getLastBoughtPlanType(): ?PaymentsPlans
    {
        return $this->lastBoughtPlanType;
    }

    public function setLastBoughtPlanType(?PaymentsPlans $lastBoughtPlanType): self
    {
        $this->lastBoughtPlanType = $lastBoughtPlanType;

        return $this;
    }

    public function getDisplayName(): ?string
    {
        return $this->displayName;
    }

    public function setDisplayName(?string $displayName): self
    {
        $this->displayName = $displayName;

        return $this;
    }

    public function getCategory(): ?UserCategories
    {
        return $this->category;
    }

    public function setCategory(?UserCategories $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getStudentInfo(): ?StudentInfo
    {
        return $this->studentInfo;
    }

    public function setStudentInfo(?StudentInfo $studentInfo): self
    {
        // unset the owning side of the relation if necessary
        if ($studentInfo === null && $this->studentInfo !== null) {
            $this->studentInfo->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($studentInfo !== null && $studentInfo->getUser() !== $this) {
            $studentInfo->setUser($this);
        }

        $this->studentInfo = $studentInfo;

        return $this;
    }

    public function getJobSeekerInfo(): ?JobSeekerInfo
    {
        return $this->jobSeekerInfo;
    }

    public function setJobSeekerInfo(?JobSeekerInfo $jobSeekerInfo): self
    {
        // unset the owning side of the relation if necessary
        if ($jobSeekerInfo === null && $this->jobSeekerInfo !== null) {
            $this->jobSeekerInfo->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($jobSeekerInfo !== null && $jobSeekerInfo->getUser() !== $this) {
            $jobSeekerInfo->setUser($this);
        }

        $this->jobSeekerInfo = $jobSeekerInfo;

        return $this;
    }

    public function getProInfo(): ?ProInfo
    {
        return $this->proInfo;
    }

    public function setProInfo(?ProInfo $proInfo): self
    {
        // unset the owning side of the relation if necessary
        if ($proInfo === null && $this->proInfo !== null) {
            $this->proInfo->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($proInfo !== null && $proInfo->getUser() !== $this) {
            $proInfo->setUser($this);
        }

        $this->proInfo = $proInfo;

        return $this;
    }

    public function getCoverURL(): ?string
    {
        return $this->coverURL;
    }

    public function setCoverURL(?string $coverURL): self
    {
        $this->coverURL = $coverURL;

        return $this;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(?string $about): self
    {
        $this->about = $about;

        return $this;
    }

    public function getIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(?bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getVerificationToken(): ?string
    {
        return $this->verificationToken;
    }

    public function setVerificationToken(?string $verificationToken): self
    {
        $this->verificationToken = $verificationToken;

        return $this;
    }

    public function getPhysicalAddress(): ?string
    {
        return $this->physicalAddress;
    }

    public function setPhysicalAddress(?string $physicalAddress): self
    {
        $this->physicalAddress = $physicalAddress;

        return $this;
    }

    public function getYearOfCreation(): ?string
    {
        return $this->yearOfCreation;
    }

    public function setYearOfCreation(?string $yearOfCreation): self
    {
        $this->yearOfCreation = $yearOfCreation;

        return $this;
    }

    public function getNumberOfEmployees(): ?string
    {
        return $this->numberOfEmployees;
    }

    public function setNumberOfEmployees(?string $numberOfEmployees): self
    {
        $this->numberOfEmployees = $numberOfEmployees;

        return $this;
    }

    public function getRangeOfYearlyRevenues(): ?string
    {
        return $this->rangeOfYearlyRevenues;
    }

    public function setRangeOfYearlyRevenues(?string $rangeOfYearlyRevenues): self
    {
        $this->rangeOfYearlyRevenues = $rangeOfYearlyRevenues;

        return $this;
    }

    public function getTypeOfCompany(): ?string
    {
        return $this->typeOfCompany;
    }

    public function setTypeOfCompany(?string $typeOfCompany): self
    {
        $this->typeOfCompany = $typeOfCompany;

        return $this;
    }

    public function getPhaseOfTheCompany(): ?string
    {
        return $this->phaseOfTheCompany;
    }

    public function setPhaseOfTheCompany(?string $phaseOfTheCompany): self
    {
        $this->phaseOfTheCompany = $phaseOfTheCompany;

        return $this;
    }

    public function getRegistrationNumber(): ?string
    {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber(?string $registrationNumber): self
    {
        $this->registrationNumber = $registrationNumber;

        return $this;
    }

    public function getContactPerson(): ?string
    {
        return $this->contactPerson;
    }

    public function setContactPerson(?string $contactPerson): self
    {
        $this->contactPerson = $contactPerson;

        return $this;
    }

    public function getShortCompanyDescription(): ?string
    {
        return $this->shortCompanyDescription;
    }

    public function setShortCompanyDescription(?string $shortCompanyDescription): self
    {
        $this->shortCompanyDescription = $shortCompanyDescription;

        return $this;
    }

    public function getInterests(): ?string
    {
        return $this->interests;
    }

    public function setInterests(?string $interests): self
    {
        $this->interests = $interests;

        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): self
    {
        $this->companyName = $companyName;

        return $this;
    }

    public function getIsLeagalEntity(): ?bool
    {
        return $this->isLeagalEntity;
    }

    public function setIsLeagalEntity(bool $isLeagalEntity): self
    {
        $this->isLeagalEntity = $isLeagalEntity;

        return $this;
    } 

}
