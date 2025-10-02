<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\RecipeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Attribute\Groups;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['recipe:read']],
    denormalizationContext: ['groups' => ['recipe:write']],
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['recipe:read']],
            paginationEnabled: true,
            paginationItemsPerPage: 20
        ),
        new Get(),
        new Post(security: 'is_granted("ROLE_API_WRITE")'),
        new Put(security: 'is_granted("ROLE_API_WRITE")'),
        new Patch(security: 'is_granted("ROLE_API_WRITE")'),
        new Delete(security: 'is_granted("ROLE_API_WRITE")'),
    ]
    )]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['recipe:read', 'recipe:write'])]
    private ?int $id = null;

    public function __construct()
    {
        $this->recipeIngredients = new ArrayCollection();
        $this->favorites = new ArrayCollection();
    }

    #[ORM\Column(length: 255)]
    #[Groups(['recipe:read', 'recipe:write'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['recipe:read', 'recipe:write'])]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: RecipeIngredient::class, cascade: ['persist', 'remove'], orphanRemoval: true, fetch: 'LAZY')]
    #[Groups(['recipe:write'])]
    private Collection $recipeIngredients;

    #[ORM\Column]
    #[Groups(['recipe:read', 'recipe:write'])]
    private array $steps = [];

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['recipe:read', 'recipe:write'])]
    private ?string $imgUrl = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['recipe:read', 'recipe:write'])]
    private ?int $prepTime = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['recipe:read', 'recipe:write'])]
    private ?int $cookTime = null;

    #[ORM\Column(length: 20, nullable: true)]
    #[Groups(['recipe:read', 'recipe:write'])]
    private ?string $difficulty = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'recipes', fetch: 'LAZY')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['recipe:read'])]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'recipes', fetch: 'EAGER')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['recipe:read', 'recipe:write'])]
    private ?Category $category = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['recipe:read'])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'recipe', targetEntity: Favorite::class, cascade: ['persist', 'remove'], orphanRemoval: true, fetch: 'LAZY')]
    private Collection $favorites;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, RecipeIngredient>
     */
    public function getRecipeIngredients(): Collection
    {
        return $this->recipeIngredients;
    }

    public function addRecipeIngredient(RecipeIngredient $recipeIngredient): static
    {
        if (!$this->recipeIngredients->contains($recipeIngredient)) {
            $this->recipeIngredients->add($recipeIngredient);
            $recipeIngredient->setRecipe($this);
        }

        return $this;
    }

    public function removeRecipeIngredient(RecipeIngredient $recipeIngredient): static
    {
        if ($this->recipeIngredients->removeElement($recipeIngredient)) {
            // set the owning side to null (unless already changed)
            if ($recipeIngredient->getRecipe() === $this) {
                $recipeIngredient->setRecipe(null);
            }
        }

        return $this;
    }

    public function getSteps(): array
    {
        return $this->steps;
    }

    public function setSteps(array $steps): static
    {
        $this->steps = $steps;

        return $this;
    }

    public function getImgUrl(): ?string
    {
        return $this->imgUrl;
    }

    public function setImgUrl(?string $imgUrl): static
    {
        $this->imgUrl = $imgUrl;

        return $this;
    }


    public function getPrepTime(): ?int
    {
        return $this->prepTime;
    }

    public function setPrepTime(?int $prepTime): static
    {
        $this->prepTime = $prepTime;

        return $this;
    }

    public function getCookTime(): ?int
    {
        return $this->cookTime;
    }

    public function setCookTime(?int $cookTime): static
    {
        $this->cookTime = $cookTime;

        return $this;
    }

    public function getDifficulty(): ?string
    {
        return $this->difficulty;
    }

    public function setDifficulty(?string $difficulty): static
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Favorite>
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Favorite $favorite): static
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites->add($favorite);
            $favorite->setRecipe($this);
        }

        return $this;
    }

    public function removeFavorite(Favorite $favorite): static
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getRecipe() === $this) {
                $favorite->setRecipe(null);
            }
        }

        return $this;
    }
}
