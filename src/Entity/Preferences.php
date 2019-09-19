<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PreferencesRepository")
 */
class Preferences
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="preferences")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="bloggerpreferences")
     * @ORM\JoinColumn(nullable=false)
     */
    private $blogger;


    public function __construct(User $user, User $blogger)
    {
        $this->user = $user;
        $this->blogger = $blogger;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getBlogger(): ?User
    {
        return $this->blogger;
    }


    public function setBlogger(?User $blogger): self
    {
        $this->blogger = $blogger;

        return $this;
    }
}
