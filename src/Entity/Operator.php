<?php

namespace App\Entity;

use App\Repository\OperatorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=OperatorRepository::class)
 */
class Operator
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
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("operator:read")
     */
    private $password;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="operator", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups("operator:read")
     */
    private $person;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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
}
