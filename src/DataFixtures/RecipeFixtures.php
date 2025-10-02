<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use App\Entity\Ingredient;
use App\Entity\RecipeIngredient;
use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RecipeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Récupérer les catégories et utilisateurs existants
        $categories = $manager->getRepository(Category::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();
        $ingredients = $manager->getRepository(Ingredient::class)->findAll();

        if (empty($categories) || empty($users) || empty($ingredients)) {
            return; // Pas de données de base, on skip
        }

        // Créer quelques recettes de test
        $testRecipes = [
            [
                'title' => 'Curry de Crevettes Antillais',
                'description' => 'Un délicieux curry de crevettes aux saveurs antillaises',
                'ingredients' => [
                    ['name' => 'Crevettes', 'quantity' => '500', 'unit' => 'g'],
                    ['name' => 'Oignons', 'quantity' => '2', 'unit' => 'pièces'],
                    ['name' => 'Ail', 'quantity' => '3', 'unit' => 'gousses'],
                    ['name' => 'Lait de coco', 'quantity' => '400', 'unit' => 'ml'],
                    ['name' => 'Curry', 'quantity' => '1', 'unit' => 'c.à.c'],
                ],
                'steps' => [
                    'Préparer les ingrédients',
                    'Faire revenir les oignons et l\'ail',
                    'Ajouter les crevettes et les épices',
                    'Mouiller avec le lait de coco',
                    'Laisser mijoter 15 minutes'
                ],
                'category' => 'Antilles',
                'difficulty' => 'medium',
                'cookingTime' => 45,
                'prepTime' => 20
            ],
            [
                'title' => 'Colombo de Poulet',
                'description' => 'Un colombo traditionnel aux saveurs créoles',
                'ingredients' => [
                    ['name' => 'Poulet', 'quantity' => '1', 'unit' => 'kg'],
                    ['name' => 'Pommes de terre', 'quantity' => '500', 'unit' => 'g'],
                    ['name' => 'Oignons', 'quantity' => '2', 'unit' => 'pièces'],
                    ['name' => 'Colombo', 'quantity' => '2', 'unit' => 'c.à.s'],
                    ['name' => 'Lait de coco', 'quantity' => '300', 'unit' => 'ml'],
                ],
                'steps' => [
                    'Découper le poulet en morceaux',
                    'Faire revenir avec les oignons',
                    'Ajouter le colombo et les pommes de terre',
                    'Mouiller avec le lait de coco',
                    'Laisser mijoter 45 minutes'
                ],
                'category' => 'Antilles',
                'difficulty' => 'easy',
                'cookingTime' => 60,
                'prepTime' => 15
            ],
            [
                'title' => 'Poulet aux Bananes',
                'description' => 'Un plat traditionnel tropical',
                'ingredients' => [
                    ['name' => 'Poulet', 'quantity' => '800', 'unit' => 'g'],
                    ['name' => 'Bananes plantains', 'quantity' => '4', 'unit' => 'pièces'],
                    ['name' => 'Tomates', 'quantity' => '3', 'unit' => 'pièces'],
                    ['name' => 'Oignons', 'quantity' => '1', 'unit' => 'pièce'],
                    ['name' => 'Ail', 'quantity' => '2', 'unit' => 'gousses'],
                ],
                'steps' => [
                    'Faire revenir le poulet',
                    'Ajouter les légumes',
                    'Incorporer les bananes',
                    'Laisser mijoter 30 minutes'
                ],
                'category' => 'Tropical',
                'difficulty' => 'easy',
                'cookingTime' => 40,
                'prepTime' => 20
            ]
        ];

        foreach ($testRecipes as $recipeData) {
            $recipe = new Recipe();
            $recipe->setTitle($recipeData['title']);
            $recipe->setDescription($recipeData['description']);
            $recipe->setSteps($recipeData['steps']);
            $recipe->setDifficulty($recipeData['difficulty']);
            $recipe->setCookingTime($recipeData['cookingTime']);
            $recipe->setPrepTime($recipeData['prepTime']);
            $recipe->setCreatedAt(new \DateTime());

            // Assigner une catégorie aléatoire
            $category = $this->findCategoryByName($categories, $recipeData['category']);
            if ($category) {
                $recipe->setCategory($category);
            }

            // Assigner un utilisateur aléatoire
            $user = $users[array_rand($users)];
            $recipe->setUser($user);

            $manager->persist($recipe);

            // Créer les relations avec les ingrédients
            foreach ($recipeData['ingredients'] as $ingredientData) {
                $ingredient = $this->findIngredientByName($ingredients, $ingredientData['name']);
                if ($ingredient) {
                    $recipeIngredient = new RecipeIngredient();
                    $recipeIngredient->setRecipe($recipe);
                    $recipeIngredient->setIngredient($ingredient);
                    $recipeIngredient->setQuantity($ingredientData['quantity']);
                    $recipeIngredient->setUnit($ingredientData['unit']);

                    $manager->persist($recipeIngredient);
                }
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            UserFixtures::class,
            IngredientFixtures::class,
        ];
    }

    private function findCategoryByName(array $categories, string $name): ?Category
    {
        foreach ($categories as $category) {
            if ($category->getName() === $name) {
                return $category;
            }
        }
        return null;
    }

    private function findIngredientByName(array $ingredients, string $name): ?Ingredient
    {
        foreach ($ingredients as $ingredient) {
            if ($ingredient->getName() === $name) {
                return $ingredient;
            }
        }
        return null;
    }
}
