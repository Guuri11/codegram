<?php

namespace App\Entity;

use App\Repository\FollowingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FollowingRepository::class)
 */
class Following
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="followings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="followers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_followed;

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

    public function getUserFollowed(): ?User
    {
        return $this->user_followed;
    }

    public function setUserFollowed(?User $user_followed): self
    {
        $this->user_followed = $user_followed;

        return $this;
    }
}
