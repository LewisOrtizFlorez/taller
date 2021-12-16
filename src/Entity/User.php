<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @ORM\HasLifecycleCallbacks()
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("operator:read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("operator:read")
     */
    private $first_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("operator:read")
     */
    private $last_name;

    /**
     * @ORM\Column(type="string", length=15, nullable=true)
     * @Groups("operator:read")
     */
    private $phone;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("operator:read")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups("operator:read")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups("operator:read")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Role::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("operator:read")
     */   

    private $role;

    /**
     * @ORM\OneToOne(targetEntity=Operator::class, mappedBy="person", cascade={"persist", "remove"})
     */
    private $operator;

    /**
     * @ORM\OneToOne(targetEntity=Patient::class, mappedBy="person", cascade={"persist", "remove"})
     * @Groups("operator:read")
     */
    private $patient;

 
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getOperator(): ?Operator
    {
        return $this->operator;
    }

    public function setOperator(Operator $operator): self
    {
        // set the owning side of the relation if necessary
        if ($operator->getPerson() !== $this) {
            $operator->setPerson($this);
        }

        $this->operator = $operator;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(Patient $patient): self
    {
        // set the owning side of the relation if necessary
        if ($patient->getPerson() !== $this) {
            $patient->setPerson($this);
        }

        $this->patient = $patient;

        return $this;
    }
    
    /**
     *@ORM\PrePersist
     */
    public function setCreatedAtValue(){
        $this->created_at = new \DateTimeImmutable();
    }
    /**
     *@ORM\PrePersist
     */
    public function setUpdatedAtValue(){
        $this->updated_at = new \DateTimeImmutable();
    }
    /**
     *@ORM\PrePersist
     */
    public function setStatustValue(){
        $this->status = true;
    }

}
