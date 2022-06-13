<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
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
    private $username;

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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="id_parent")
     */
    private $parent;

    /**
     * @ORM\ManyToOne(targetEntity=Kyu::class, inversedBy="users")
     */
    private $kyu;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $dan;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isMaster;

    /**
     * @ORM\OneToMany(targetEntity=Address::class, mappedBy="user")
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity=Dojo::class, mappedBy="user")
     */
    private $dojo;

    public function __construct()
    {
        $this->address = new ArrayCollection();
        $this->dojo = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getKyu(): ?Kyu
    {
        return $this->kyu;
    }

    public function setKyu(?Kyu $kyu): self
    {
        $this->kyu = $kyu;

        return $this;
    }

    public function getDan(): ?int
    {
        return $this->dan;
    }

    public function setDan(?int $dan): self
    {
        $this->dan = $dan;

        return $this;
    }

    public function isIsMaster(): ?bool
    {
        return $this->isMaster;
    }

    public function setIsMaster(?bool $isMaster): self
    {
        $this->isMaster = $isMaster;

        return $this;
    }

    /**
     * @return Collection<int, Address>
     */
    public function getAddress(): Collection
    {
        return $this->address;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->address->contains($address)) {
            $this->address[] = $address;
            $address->setUser($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->address->removeElement($address)) {
            // set the owning side to null (unless already changed)
            if ($address->getUser() === $this) {
                $address->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Dojo>
     */
    public function getDojo(): Collection
    {
        return $this->dojo;
    }

    public function addDojo(Dojo $dojo): self
    {
        if (!$this->dojo->contains($dojo)) {
            $this->dojo[] = $dojo;
            $dojo->setUser($this);
        }

        return $this;
    }

    public function removeDojo(Dojo $dojo): self
    {
        if ($this->dojo->removeElement($dojo)) {
            // set the owning side to null (unless already changed)
            if ($dojo->getUser() === $this) {
                $dojo->setUser(null);
            }
        }

        return $this;
    }

}
