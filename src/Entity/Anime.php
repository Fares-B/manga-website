<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnimeRepository")
 */
class Anime
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "Your country must be at least {{ limit }} characters long",
     *      maxMessage = "Your country cannot be longer than {{ limit }} characters"
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(
     *      min = 5,
     *      minMessage = "Your content must be at least {{ limit }} characters long"
     * )
     */
    private $content;
    
    /**
     * @ORM\Column(type="smallint")
     * @Assert\Range(
     *      min = 1980,
     *      max = 2020,
     *      minMessage = "You must be at least {{ limit }} year tall to enter",
     *      maxMessage = "You cannot be taller than {{ limit }} year to enter"
     * )
     */
    private $published;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Your alternative title cannot be longer than {{ limit }} characters"
     * )
     */
    private $alternative_title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 5,
     *      max = 255,
     *      minMessage = "Your author name must be at least {{ limit }} characters long",
     *      maxMessage = "Your author name cannot be longer than {{ limit }} characters"
     * )
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 3,
     *      max = 255,
     *      minMessage = "Your country must be at least {{ limit }} characters long",
     *      maxMessage = "Your country cannot be longer than {{ limit }} characters"
     * )
     */
    private $country;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Url(
     *      message = "The image url '{{ value }}' is not a valid url",
     * )
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max = 255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type", inversedBy="animes")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Status", inversedBy="animes")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $status;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Kind", inversedBy="animes")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $kind;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Episode", mappedBy="anime")
     */
    private $episodes;

    public function __construct()
    {
        $this->kind = new ArrayCollection();
        $this->episodes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getPublished(): ?int
    {
        return $this->published;
    }

    public function setPublished(int $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getAlternativeTitle(): ?string
    {
        return $this->alternative_title;
    }

    public function setAlternativeTitle(?string $alternative_title): self
    {
        $this->alternative_title = $alternative_title;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Kind[]
     */
    public function getKind(): Collection
    {
        return $this->kind;
    }

    public function addKind(Kind $kind): self
    {
        if (!$this->kind->contains($kind)) {
            $this->kind[] = $kind;
        }

        return $this;
    }

    public function removeKind(Kind $kind): self
    {
        if ($this->kind->contains($kind)) {
            $this->kind->removeElement($kind);
        }

        return $this;
    }

    /**
     * @return Collection|Episode[]
     */
    public function getEpisodes(): Collection
    {
        return $this->episodes;
    }

    public function addEpisode(Episode $episode): self
    {
        if (!$this->episodes->contains($episode)) {
            $this->episodes[] = $episode;
            $episode->setAnime($this);
        }

        return $this;
    }

    public function removeEpisode(Episode $episode): self
    {
        if ($this->episodes->contains($episode)) {
            $this->episodes->removeElement($episode);
            // set the owning side to null (unless already changed)
            if ($episode->getAnime() === $this) {
                $episode->setAnime(null);
            }
        }

        return $this;
    }
}
