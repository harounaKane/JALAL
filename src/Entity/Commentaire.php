<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    /**
     * @ORM\Column(type="datetime")
     */
    private $comment_at;

    /**
     * @ORM\Column(type="text")
     */
    private $comment;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $like_comment;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $unlike_comment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getCommentAt(): ?\DateTimeInterface
    {
        return $this->comment_at;
    }

    public function setCommentAt(\DateTimeInterface $comment_at): self
    {
        $this->comment_at = $comment_at;

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

    public function getLikeComment(): ?int
    {
        return $this->like_comment;
    }

    public function setLikeComment(?int $like_comment): self
    {
        $this->like_comment = $like_comment;

        return $this;
    }

    public function getUnlikeComment(): ?int
    {
        return $this->unlike_comment;
    }

    public function setUnlikeComment(?int $unlike_comment): self
    {
        $this->unlike_comment = $unlike_comment;

        return $this;
    }
}
