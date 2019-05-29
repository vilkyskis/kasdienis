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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="author")
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Post", mappedBy="likedBy")
     */
    private $liked_posts;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Comment", mappedBy="likedBy")
     */
    private $liked_comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Topic", mappedBy="author")
     */
    private $topics;


    public function __construct()
    {
        parent::__construct();
        $this->posts = new ArrayCollection();
        $this->createdposts = new ArrayCollection();
        $this->addRole("ROLE_USER");
        $this->comments = new ArrayCollection();
        $this->liked_posts = new ArrayCollection();
        $this->liked_comments = new ArrayCollection();
        $this->topics = new ArrayCollection();
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

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Post[]
     */
    public function getLikedPosts(): Collection
    {
        return $this->liked_posts;
    }

    public function getLikedPostsCount()
    {
        return $this->liked_posts->count;
    }


    public function addLikedPost(Post $likedPost): self
    {
        if (!$this->liked_posts->contains($likedPost)) {
            $this->liked_posts[] = $likedPost;
            $likedPost->addLikedBy($this);
        }

        return $this;
    }

    public function removeLikedPost(Post $likedPost): self
    {
        if ($this->liked_posts->contains($likedPost)) {
            $this->liked_posts->removeElement($likedPost);
            $likedPost->removeLikedBy($this);
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getLikedComments(): Collection
    {
        return $this->liked_comments;
    }

    public function addLikedComment(Comment $likedComment): self
    {
        if (!$this->liked_comments->contains($likedComment)) {
            $this->liked_comments[] = $likedComment;
            $likedComment->addLikedBy($this);
        }

        return $this;
    }

    public function removeLikedComment(Comment $likedComment): self
    {
        if ($this->liked_comments->contains($likedComment)) {
            $this->liked_comments->removeElement($likedComment);
            $likedComment->removeLikedBy($this);
        }

        return $this;
    }

    /**
     * @return Collection|Topic[]
     */
    public function getTopics(): Collection
    {
        return $this->topics;
    }

    public function addTopic(Topic $topic): self
    {
        if (!$this->topics->contains($topic)) {
            $this->topics[] = $topic;
            $topic->setAuthor($this);
        }

        return $this;
    }

    public function removeTopic(Topic $topic): self
    {
        if ($this->topics->contains($topic)) {
            $this->topics->removeElement($topic);
            // set the owning side to null (unless already changed)
            if ($topic->getAuthor() === $this) {
                $topic->setAuthor(null);
            }
        }

        return $this;
    }


}
