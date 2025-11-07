<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $accountType = null;

    /**
     * @var Collection<int, Cours>
     */
    #[ORM\OneToMany(targetEntity: Cours::class, mappedBy: 'prof')]
    private Collection $cours;

    /**
     * @var Collection<int, ForumPost>
     */
    #[ORM\OneToMany(targetEntity: ForumPost::class, mappedBy: 'author')]
    private Collection $forumPosts;

    /**
     * @var Collection<int, ForumReply>
     */
    #[ORM\OneToMany(targetEntity: ForumReply::class, mappedBy: 'author')]
    private Collection $forumReplies;

    public function __construct()
    {
        $this->cours = new ArrayCollection();
        $this->forumPosts = new ArrayCollection();
        $this->forumReplies = new ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getAccountType(): ?string
    {
        return $this->accountType;
    }
    
    public function setAccountType(string $accountType): static
    {
        $this->accountType = $accountType;
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
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0".self::class."\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
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
     * @return Collection<int, Cours>
     */
    public function getCours(): Collection
    {
        return $this->cours;
    }

    public function addCour(Cours $cour): static
    {
        if (!$this->cours->contains($cour)) {
            $this->cours->add($cour);
            $cour->setProf($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): static
    {
        if ($this->cours->removeElement($cour)) {
            // set the owning side to null (unless already changed)
            if ($cour->getProf() === $this) {
                $cour->setProf(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ForumPost>
     */
    public function getForumPosts(): Collection
    {
        return $this->forumPosts;
    }

    public function addForumPost(ForumPost $forumPost): static
    {
        if (!$this->forumPosts->contains($forumPost)) {
            $this->forumPosts->add($forumPost);
            $forumPost->setAuthor($this);
        }

        return $this;
    }

    public function removeForumPost(ForumPost $forumPost): static
    {
        if ($this->forumPosts->removeElement($forumPost)) {
            // set the owning side to null (unless already changed)
            if ($forumPost->getAuthor() === $this) {
                $forumPost->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ForumReply>
     */
    public function getForumReplies(): Collection
    {
        return $this->forumReplies;
    }

    public function addForumReply(ForumReply $forumReply): static
    {
        if (!$this->forumReplies->contains($forumReply)) {
            $this->forumReplies->add($forumReply);
            $forumReply->setAuthor($this);
        }

        return $this;
    }

    public function removeForumReply(ForumReply $forumReply): static
    {
        if ($this->forumReplies->removeElement($forumReply)) {
            // set the owning side to null (unless already changed)
            if ($forumReply->getAuthor() === $this) {
                $forumReply->setAuthor(null);
            }
        }

        return $this;
    }

    //to string method
    public function __toString(): string
    {
        return $this->username ?? '';
    }

    //
    

    
}
