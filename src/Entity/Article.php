<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $locale;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="articles")
     */
    private $category;

    /**
     * @ORM\Column(type="boolean")
     */
    private $published;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="localizations")
     */
    private $parentLocalization;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="parentLocalization")
     */
    private $localizations;

    public function __construct()
    {
        $this->localizations = new ArrayCollection();
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

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getParentLocalization(): ?self
    {
        return $this->parentLocalization;
    }

    public function setParentLocalization(?self $parentLocalization): self
    {
        $this->parentLocalization = $parentLocalization;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getLocalizations(): Collection
    {
        return $this->localizations;
    }

    public function addLocalization(self $localization): self
    {
        if (!$this->localizations->contains($localization)) {
            $this->localizations[] = $localization;
            $localization->setParentLocalization($this);
        }

        return $this;
    }

    public function removeLocalization(self $localization): self
    {
        if ($this->localizations->removeElement($localization)) {
            // set the owning side to null (unless already changed)
            if ($localization->getParentLocalization() === $this) {
                $localization->setParentLocalization(null);
            }
        }

        return $this;
    }
}
