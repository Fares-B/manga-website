<?php

namespace App\Entity\Episode;

use App\Entity\Anime\Anime;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Episode\EpisodeRepository")
 */
class Episode
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     * @Assert\Range(
     *      min = 1,
     *      minMessage = "You must be at least {{ limit }} season tall to enter"
     * )
     */
    private $season;

    /**
     * @ORM\Column(type="smallint")
     * @Assert\Range(
     *      min = 0,
     *      minMessage = "You must be at least {{ limit }} season tall to enter"
     * )
     */
    private $episode;

    /**
     * @ORM\Column(type="text")
     */
    private $video;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max = 255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Anime\Anime", inversedBy="episodes")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $anime;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Episode\Voice", inversedBy="episodes")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $voice;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Episode\Format", inversedBy="episodes")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $format;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeason(): ?int
    {
        return $this->season;
    }

    public function setSeason(int $season): self
    {
        $this->season = $season;

        return $this;
    }

    public function getEpisode(): ?int
    {
        return $this->episode;
    }

    public function setEpisode(int $episode): self
    {
        $this->episode = $episode;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(string $video): self
    {
        $this->video = $video;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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

    public function getVoice(): ?Voice
    {
        return $this->voice;
    }

    public function setVoice(?Voice $voice): self
    {
        $this->voice = $voice;

        return $this;
    }

    public function getFormat(): ?Format
    {
        return $this->format;
    }

    public function setFormat(?Format $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function getTitle(): ?string
    {
        return  
            (($this->getSeason() != 1) ? 'Saison ' . $this->getSeason() . ' ': '') .
            $this->getFormat()->getName() . ' ' .
            $this->getEpisode() . ' ' .
            $this->getVoice()->getName()
        ;
    }
}
