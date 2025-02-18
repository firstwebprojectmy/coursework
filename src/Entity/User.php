<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *@UniqueEntity("email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
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
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $secondName;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isBanned;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isConfirmed;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $confirmeHash;

    /**
     * @ORM\Column(type="date")
     */
    private $regisretedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageURL;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isBlogger;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isComfirmedByModerator;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $shortInformation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Preferences", mappedBy="user")
     */
    private $preferences;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Preferences", mappedBy="blogger")
     */
    private $bloggerpreferences;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="user")
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Like", mappedBy="user")
     */
    private $likes;

    public function __construct()
    {
        $this->preferences = new ArrayCollection();
        $this->bloggerpreferences = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->likes = new ArrayCollection();
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
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getSecondName(): ?string
    {
        return $this->secondName;
    }

    public function setSecondName(string $secondName): self
    {
        $this->secondName = $secondName;

        return $this;
    }

    public function getIsBanned(): ?bool
    {
        return $this->isBanned;
    }

    public function setIsBanned(bool $isBanned): self
    {
        $this->isBanned = $isBanned;

        return $this;
    }

    public function getIsConfirmed(): ?bool
    {
        return $this->isConfirmed;
    }

    public function setIsConfirmed(bool $isConfirmed): self
    {
        $this->isConfirmed = $isConfirmed;

        return $this;
    }

    public function getConfirmeHash(): ?string
    {
        return $this->confirmeHash;
    }

    public function setConfirmeHash(string $confirmeHash): self
    {
        $this->confirmeHash = $confirmeHash;

        return $this;
    }

    public function getRegisretedAt(): ?\DateTimeInterface
    {
        return $this->regisretedAt;
    }

    public function setRegisretedAt(\DateTimeInterface $regisretedAt): self
    {
        $this->regisretedAt = $regisretedAt;

        return $this;
    }

    public function getImageURL(): ?string
    {
        return $this->imageURL;
    }

    public function setImageURL(?string $imageURL): self
    {
        $this->imageURL = $imageURL;

        return $this;
    }

    public function getIsBlogger(): ?bool
    {
        return $this->isBlogger;
    }

    public function setIsBlogger(bool $isBlogger): self
    {
        if ($isBlogger){
            $this->setRoles(array("ROLE_BLOGGER"));
        }else{
            $this->setRoles(array("ROLE_USER"));
        }
        $this->isBlogger = $isBlogger;
        return $this;
    }

    public function getIsComfirmedByModerator(): ?bool
    {
        return $this->isComfirmedByModerator;
    }

    public function setIsComfirmedByModerator(?bool $isComfirmedByModerator): self
    {
        $this->isComfirmedByModerator = $isComfirmedByModerator;

        return $this;
    }

    public function getShortInformation(): ?string
    {
        return $this->shortInformation;
    }

    public function setShortInformation(?string $shortInformation): self
    {
        $this->shortInformation = $shortInformation;

        return $this;
    }

    /**
     * @return Collection|Preferences[]
     */
    public function getPreferences(): Collection
    {
        return $this->preferences;
    }

    public function addPreference(Preferences $preference): self
    {
        if (!$this->preferences->contains($preference)) {
            $this->preferences[] = $preference;
            $preference->setUser($this);
        }

        return $this;
    }

    public function removePreference(Preferences $preference): self
    {
        if ($this->preferences->contains($preference)) {
            $this->preferences->removeElement($preference);
            // set the owning side to null (unless already changed)
            if ($preference->getUser() === $this) {
                $preference->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Preferences[]
     */
    public function getBloggerpreferences(): Collection
    {
        return $this->bloggerpreferences;
    }

    public function addBloggerpreference(Preferences $bloggerpreference): self
    {
        if (!$this->bloggerpreferences->contains($bloggerpreference)) {
            $this->bloggerpreferences[] = $bloggerpreference;
            $bloggerpreference->setBlogger($this);
        }

        return $this;
    }

    public function removeBloggerpreference(Preferences $bloggerpreference): self
    {
        if ($this->bloggerpreferences->contains($bloggerpreference)) {
            $this->bloggerpreferences->removeElement($bloggerpreference);
            // set the owning side to null (unless already changed)
            if ($bloggerpreference->getBlogger() === $this) {
                $bloggerpreference->setBlogger(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Like[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Like $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setUser($this);
        }

        return $this;
    }

    public function removeLike(Like $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getUser() === $this) {
                $like->setUser(null);
            }
        }

        return $this;
    }
}
