<?php

namespace App\Entity\Comment;

use App\Entity\Anime\Anime;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Comment\CommentRepository")
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
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max=255, maxMessage="Le commentaire ne peut depasser 255 caractères")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Anime\Anime", inversedBy="comments")
     */
    private $anime;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
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

    public function getAnime(): ?Anime
    {
        return $this->anime;
    }

    public function setAnime(?Anime $anime): self
    {
        $this->anime = $anime;

        return $this;
    }

    public function isAuthorizedEdit(?UserInterface $user): bool
    {
        // si l'utilisateur est connecté
        if($user) {
            $userComment = $this->getUser();
            // si c'est son commentaire
            if($userComment === $user) {
                return true;
            }
            // si possède le role moderateur et que le proprietaire du commentaire n'est pas un moderateur
            if(in_array('ROLE_MODERATOR', $user->getRoles()) && !in_array('ROLE_MODERATOR', $userComment->getRoles()) /*&& !in_array('ROLE_ADMIN', $userComment->getRoles())*/) {
                return true;
            }
        }
        return false;
        // return app.user == comment.user or (is_granted('ROLE_MODERATOR') and ('ROLE_MODERATOR' not in comment.user.roles));
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
