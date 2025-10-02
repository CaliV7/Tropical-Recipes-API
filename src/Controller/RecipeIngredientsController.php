<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Repository\RecipeIngredientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/recipes/{id}/ingredients', name: 'api_recipe_ingredients_')]
class RecipeIngredientsController extends AbstractController
{
    public function __construct(
        private RecipeIngredientRepository $recipeIngredientRepository,
        private SerializerInterface $serializer
    ) {}

    #[Route('', name: 'get', methods: ['GET'])]
    public function getIngredients(Recipe $recipe): JsonResponse
    {
        $ingredients = $this->recipeIngredientRepository->findBy(['recipe' => $recipe]);

        $data = $this->serializer->serialize($ingredients, 'json', [
            'groups' => ['recipe_ingredient:read']
        ]);

        return new JsonResponse($data, 200, [], true);
    }
}
