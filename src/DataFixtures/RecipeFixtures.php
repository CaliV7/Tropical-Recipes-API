<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RecipeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $file = __DIR__ . '/data/recipes_200.json';
        if (!file_exists($file)) {
            throw new \RuntimeException("Fichier de données introuvable : $file");
        }
        $json = file_get_contents($file);
        $items = json_decode($json, true, 512, JSON_THROW_ON_ERROR);

        foreach ($items as $item) {
            $recipe = new Recipe();
            $recipe->setTitle($item['title']);
            $recipe->setDescription($item['description'] ?? null);
            $recipe->setIngredients($item['ingredients'] ?? []);
            $recipe->setSteps($item['steps'] ?? []);
            $recipe->setImgUrl($item['imgUrl'] ?? null);
            $recipe->setCategory($item['category'] ?? null);
            $recipe->setLevel($item['level'] ?? null);
            $recipe->setPrepTime($item['prepTime'] ?? null);
            $recipe->setCookTime($item['cookTime'] ?? null);

            $manager->persist($recipe);
        }

        $manager->flush();
    }
}
