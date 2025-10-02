<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Fixture principale qui orchestre le chargement de toutes les autres fixtures
 */
class AppFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // Cette fixture orchestre le chargement de toutes les autres
        // Les dépendances sont gérées par getDependencies()

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            IngredientFixtures::class,
            UserFixtures::class,
            RecipeFixtures::class,
        ];
    }
}
