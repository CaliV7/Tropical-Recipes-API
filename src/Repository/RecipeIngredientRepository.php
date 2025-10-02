<?php

namespace App\Repository;

use App\Entity\RecipeIngredient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RecipeIngredient>
 */
class RecipeIngredientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecipeIngredient::class);
    }

    /**
     * Trouve tous les ingrédients d'une recette
     */
    public function findByRecipe(int $recipeId): array
    {
        return $this->createQueryBuilder('ri')
            ->join('ri.ingredient', 'i')
            ->where('ri.recipe = :recipeId')
            ->setParameter('recipeId', $recipeId)
            ->orderBy('i.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Trouve toutes les recettes contenant un ingrédient spécifique
     */
    public function findByIngredient(int $ingredientId): array
    {
        return $this->createQueryBuilder('ri')
            ->join('ri.recipe', 'r')
            ->where('ri.ingredient = :ingredientId')
            ->setParameter('ingredientId', $ingredientId)
            ->orderBy('r.title', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
