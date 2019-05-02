<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Post", inversedBy="users")
     */
    private $posts;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $registered;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="author")
     */
    private $createdposts;

    public function __construct()
    {
        parent::__construct();
        $this->posts = new ArrayCollection();
        $this->createdposts = new ArrayCollection();
        $this->addRole("ROLE_USER");
    }

    public function getId(): ?int
    {
        return $this->id;
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
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
        }

        return $this;
    }

    public function getRegistered(): ?\DateTimeInterface
    {
        return $this->registered;
    }

    public function setRegistered(\DateTimeInterface $registered): self
    {
        $this->registered = $registered;

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getCreatedposts(): Collection
    {
        return $this->createdposts;
    }

    public function addCreatedpost(Post $createdpost): self
    {
        if (!$this->createdposts->contains($createdpost)) {
            $this->createdposts[] = $createdpost;
            $createdpost->setAuthor($this);
        }

        return $this;
    }

    public function removeCreatedpost(Post $createdpost): self
    {
        if ($this->createdposts->contains($createdpost)) {
            $this->createdposts->removeElement($createdpost);
            // set the owning side to null (unless already changed)
            if ($createdpost->getAuthor() === $this) {
                $createdpost->setAuthor(null);
            }
        }

        return $this;
    }
}
