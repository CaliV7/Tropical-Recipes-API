<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IngredientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $ingredients = [
            // Viandes
            'Poulet',
            'Porc',
            'Bœuf',
            'Agneau',

            // Poissons
            'Crevettes',
            'Morue',
            'Saumon',
            'Thon',

            // Légumes
            'Oignons',
            'Ail',
            'Tomates',
            'Poivrons',
            'Pommes de terre',
            'Carottes',
            'Courgettes',
            'Aubergines',

            // Fruits tropicaux
            'Bananes plantains',
            'Mangues',
            'Ananas',
            'Coco',
            'Citron vert',
            'Limes',

            // Épices et aromates
            'Curry',
            'Colombo',
            'Cannelle',
            'Gingembre',
            'Piment',
            'Persil',
            'Coriandre',
            'Basilic',

            // Produits laitiers
            'Lait de coco',
            'Crème fraîche',
            'Fromage',

            // Céréales et légumineuses
            'Riz',
            'Lentilles',
            'Haricots rouges',
            'Pois chiches',

            // Huiles et condiments
            'Huile d\'olive',
            'Vinaigre',
            'Sel',
            'Poivre',
            'Sucre'
        ];

        foreach ($ingredients as $ingredientName) {
            $ingredient = new Ingredient();
            $ingredient->setName($ingredientName);
            $manager->persist($ingredient);
        }

        $manager->flush();
    }
}
