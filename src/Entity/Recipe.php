<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\RecipeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
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
        new GetCollection(),
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

    #[ORM\Column(length: 255)]
    #[Groups(['recipe:read', 'recipe:write'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['recipe:read', 'recipe:write'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['recipe:read', 'recipe:write'])]
    private array $ingredients = [];

    #[ORM\Column]
    #[Groups(['recipe:read', 'recipe:write'])]
    private array $steps = [];

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['recipe:read', 'recipe:write'])]
    private ?string $imgUrl = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Groups(['recipe:read', 'recipe:write'])]
    private ?string $category = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['recipe:read', 'recipe:write'])]
    private ?string $level = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['recipe:read', 'recipe:write'])]
    private ?int $prepTime = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['recipe:read', 'recipe:write'])]
    private ?int $cookTime = null;

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

    public function getIngredients(): array
    {
        return $this->ingredients;
    }

    public function setIngredients(array $ingredients): static
    {
        $this->ingredients = $ingredients;

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

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(?string $level): static
    {
        $this->level = $level;

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
}
