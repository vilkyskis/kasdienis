<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Date;

    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post", inversedBy="comments")
     * @ORM\JoinColumn(nullable=true)
     */
    private $post;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="liked_comments")
     */
    private $likedBy;

    /**
     * @ORM\Column(type="integer")
     */
    private $likedCount;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Comment", inversedBy="response")
     */
    private $response_comment;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="response_comment")
     */
    private $response;

    public function __construct()
    {
        $this->Date = new \DateTime();
        $this->likedBy = new ArrayCollection();
        $this->likedCount = 0;
        $this->response = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }

    public function __toString() {
        $returnString = $this->Date->format('Y-m-d H:i:s')."\r\n".$this->author."\r\n".$this->comment;
        return $returnString;
    }

    /**
     * @return Collection|User[]
     */
    public function getLikedBy(): Collection
    {
        return $this->likedBy;
    }

    public function addLikedBy(User $likedBy)
    {
        if (!$this->likedBy->contains($likedBy)) {
            $this->likedBy[] = $likedBy;
            return true;
        }

        return false;
    }

    public function removeLikedBy(User $likedBy): self
    {
        if ($this->likedBy->contains($likedBy)) {
            $this->likedBy->removeElement($likedBy);
        }

        return $this;
    }

    public function getLikedCount(): ?int
    {
        return $this->likedCount;
    }

    public function setLikedCount(int $likedCount): self
    {
        $this->likedCount = $likedCount;

        return $this;
    }

    public function getResponseComment(): ?self
    {
        return $this->response_comment;
    }

    public function setResponseComment(?self $response_comment): self
    {
        $this->response_comment = $response_comment;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getResponse(): Collection
    {
        return $this->response;
    }

    public function addResponse(self $response): self
    {
        if (!$this->response->contains($response)) {
            $this->response[] = $response;
            $response->setResponseComment($this);
        }

        return $this;
    }

    public function removeResponse(self $response): self
    {
        if ($this->response->contains($response)) {
            $this->response->removeElement($response);
            // set the owning side to null (unless already changed)
            if ($response->getResponseComment() === $this) {
                $response->setResponseComment(null);
            }
        }

        return $this;
    }
}
