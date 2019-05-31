<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TopicRepository")
 */
class Topic
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="topic", orphanRemoval=true)
     * @ORM\OrderBy({"upvotes" = "Desc"})
     */
    private $posts;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $Description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="topics")
     */
    private $author;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return (string)$this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|post[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setTopic($this);
        }

        return $this;
    }

    public function removePost(post $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getTopic() === $this) {
                $post->setTopic(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        try
        {
            return (string) $this->name;
        }
        catch (Exception $exception)
        {
            return '';
        }
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
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

    public function getAuthorsCount($posts)
    {
        $authors = array();
        foreach($posts as $post){
            // Count every poster
            $author = $post->getAuthor();
            if(!in_array($author,$authors)){
                $authors[] = $author;
            }

            // Count every commenter
            foreach($post->getComments() as $comment){
                $author = $comment->getAuthor();
                if(!in_array($author,$authors)){
                    $authors[] = $author;
                }

                //Count every comment liker
                foreach($comment->getLikedBy() as $user_){
                    if(!in_array($user_,$authors)){
                        $authors[] = $user_;
                    }
                }
            }

            //Count every post liker
            foreach($post->getLikedBy() as $user){
                if(!in_array($user,$authors)){
                    $authors[] = $user;
                }
            }
        }
        return $authors;
    }
}
