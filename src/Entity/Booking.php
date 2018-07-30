<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Sven Wappler
 *
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Booking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Participant", mappedBy="booking", cascade={"persist", "remove"})
     */
    private $participants;

    /**
     * @var string
     * @ORM\Column(type="string", length=256)
     */
    private $company = '';

    /**
     * @var string
     * @ORM\Column(type="string", length=256)
     */
    private $firstName = '';


    /**
     * @var string
     * @ORM\Column(type="string", length=256)
     */
    private $lastName = '';

    /**
     * @var string
     * @ORM\Column(type="string", length=256)
     */
    private $department = '';

    /**
     * @var string
     * @ORM\Column(type="string", length=60)
     */
    private $telephone = '';

    /**
     * @var string
     * @ORM\Column(type="string", length=256)
     */
    private $street = '';

    /**
     * @var string
     * @ORM\Column(type="string", length=10)
     */
    private $housenumber = '';

    /**
     * @var string
     * @ORM\Column(type="string", length=10)
     */
    private $zipcode = '';

    /**
     * @var string
     * @ORM\Column(type="string", length=40)
     */
    private $country = '';

    /**
     * @var string
     * @ORM\Column(type="string", length=256)
     */
    private $email = '';

    /**
     * @var string
     * @ORM\Column(type="string", length=256)
     */
    private $vat = '';

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $postalInvoice = false;


    /**
     * @var ?\DateTime
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;


    /**
     * @var ?\DateTime
     * @ORM\Column(name="modified_at", type="datetime")
     */
    protected $modifiedAt;


    /**
     * @var ?\DateTime
     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
     */
    protected $deletedAt;


    /**
     * Double Opt In Key
     * @var ?\string
     * @ORM\Column(type="string", length=256)
     */
    protected $key;


    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $isConfirmed = false;



    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }


    /**
     * @return \DateTime
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getModifiedAt()
    {
        return $this->modifiedAt;
    }

    /**
     * @param mixed $modifiedAt
     */
    public function setModifiedAt($modifiedAt): void
    {
        $this->modifiedAt = $modifiedAt;
    }

    /**
     * @return mixed
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * @param mixed $deletedAt
     */
    public function setDeletedAt($deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }


    /**
     * @return string
     */
    public function getCompany(): string
    {
        return $this->company;
    }

    /**
     * @param string $company
     */
    public function setCompany(string $company): void
    {
        $this->company = $company;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getDepartment(): string
    {
        return $this->department;
    }

    /**
     * @param string $department
     */
    public function setDepartment(string $department): void
    {
        $this->department = $department;
    }

    /**
     * @return string
     */
    public function getTelephone(): string
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     */
    public function setTelephone(string $telephone): void
    {
        $this->telephone = $telephone;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    /**
     * @return string
     */
    public function getHousenumber(): string
    {
        return $this->housenumber;
    }

    /**
     * @param string $housenumber
     */
    public function setHousenumber(string $housenumber): void
    {
        $this->housenumber = $housenumber;
    }

    /**
     * @return string
     */
    public function getZipcode(): string
    {
        return $this->zipcode;
    }

    /**
     * @param string $zipcode
     */
    public function setZipcode(string $zipcode): void
    {
        $this->zipcode = $zipcode;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getVat(): string
    {
        return $this->vat;
    }

    /**
     * @param string $vat
     */
    public function setVat(string $vat): void
    {
        $this->vat = $vat;
    }

    /**
     * @return bool
     */
    public function isPostalInvoice(): bool
    {
        return $this->postalInvoice;
    }

    /**
     * @param bool $postalInvoice
     */
    public function setPostalInvoice(bool $postalInvoice): void
    {
        $this->postalInvoice = $postalInvoice;
    }


    /**
     * @return mixed
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * @param mixed $participants
     */
    public function setParticipants($participants): void
    {
        $this->participants = $participants;
    }


    public function addParticipant(Participant $participant)
    {
        $participant->setBooking($this);
        $this->participants->add($participant);
    }

    public function removeParticipant(Participant $participant)
    {

        $this->participants->removeElement($participant);

    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     */
    public function setKey($key): void
    {
        $this->key = $key;
    }

    /**
     * @return bool
     */
    public function isConfirmed(): bool
    {
        return $this->isConfirmed;
    }

    /**
     * @param bool $isConfirmed
     */
    public function setIsConfirmed(bool $isConfirmed): void
    {
        $this->isConfirmed = $isConfirmed;
    }


    /**
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps()
    {
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new \DateTime('now'));
        }
        if ($this->getModifiedAt() === null) {
            $this->setModifiedAt(new \DateTime('now'));
        }
    }


}
