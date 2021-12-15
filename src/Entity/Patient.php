<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 */
class Patient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $insureNumber;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="patient", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $person;

    /**
     * @ORM\OneToOne(targetEntity=PersonContact::class, mappedBy="patient", cascade={"persist", "remove"})
     */
    private $personContact;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getInsureNumber(): ?string
    {
        return $this->insureNumber;
    }

    public function setInsureNumber(?string $insureNumber): self
    {
        $this->insureNumber = $insureNumber;

        return $this;
    }

    public function getPerson(): ?User
    {
        return $this->person;
    }

    public function setPerson(User $person): self
    {
        $this->person = $person;

        return $this;
    }

    public function getPersonContact(): ?PersonContact
    {
        return $this->personContact;
    }

    public function setPersonContact(PersonContact $personContact): self
    {
        // set the owning side of the relation if necessary
        if ($personContact->getPatient() !== $this) {
            $personContact->setPatient($this);
        }

        $this->personContact = $personContact;

        return $this;
    }
}
