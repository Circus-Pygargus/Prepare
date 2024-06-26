<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'Ce pseudonyme est déjà utilisé !')]
#[UniqueEntity(fields: ['slug'], message: 'Ce slug d\'utilisateur est déjà utilisé !')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->ownedProjects = new ArrayCollection();
        $this->contributedProjects = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->ideas = new ArrayCollection();
        $this->isActive = false;
    }

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: 'Tu dois entrer un pseudonyme !')]
    #[Assert\Length(
        min: 3,
        max: 15,
        minMessage: 'Le pseudo doit contenir au moins {{ limit }} caractères',
        maxMessage: 'Pas plus de 15 caractères pour le pseudo ...'
    )]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToMany(targetEntity: Project::class, mappedBy: 'createdBy')]
    private Collection $ownedProjects;

    #[ORM\ManyToMany(targetEntity: Project::class, mappedBy: 'contributors')]
    private Collection $contributedProjects;

    #[ORM\OneToMany(targetEntity: Category::class, mappedBy: 'createdBy')]
    private Collection $categories;

    #[ORM\OneToMany(targetEntity: Idea::class, mappedBy: 'createdBy')]
    private Collection $ideas;

    #[ORM\Column(options: ["default" => false])]
    private ?bool $isActive = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Gedmo\Slug(fields: ['username'])]
    private ?string $slug = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
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

    public function setRoles(array $roles): static
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

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getOwnedProjects(): Collection
    {
        return $this->ownedProjects;
    }

    public function addOwnedProject(Project $ownedProject): static
    {
        if (!$this->ownedProjects->contains($ownedProject)) {
            $this->ownedProjects->add($ownedProject);
            $ownedProject->setCreatedBy($this);
        }

        return $this;
    }

    public function removeOwnedProject(Project $ownedProject): static
    {
        if ($this->ownedProjects->removeElement($ownedProject)) {
            // set the owning side to null (unless already changed)
            if ($ownedProject->getCreatedBy() === $this) {
                $ownedProject->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getContributedProjects(): Collection
    {
        return $this->contributedProjects;
    }

    public function addContributedProject(Project $contributedProject): static
    {
        if (!$this->contributedProjects->contains($contributedProject)) {
            $this->contributedProjects->add($contributedProject);
            $contributedProject->addContributor($this);
        }

        return $this;
    }

    public function removeContributedProject(Project $contributedProject): static
    {
        if ($this->contributedProjects->removeElement($contributedProject)) {
            $contributedProject->removeContributor($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
            $category->setCreatedBy($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getCreatedBy() === $this) {
                $category->setCreatedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, IDea>
     */
    public function getIdeas(): Collection
    {
        return $this->ideas;
    }

    public function addIdea(Idea $idea): static
    {
        if (!$this->ideas->contains($idea)) {
            $this->ideas->add($idea);
            $idea->setCreatedBy($this);
        }

        return $this;
    }

    public function removeIdea(Idea $idea): static
    {
        if ($this->ideas->removeElement($idea)) {
            // set the owning side to null (unless already changed)
            if ($idea->getCreatedBy() === $this) {
                $idea->setCreatedBy(null);
            }
        }

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }
}
