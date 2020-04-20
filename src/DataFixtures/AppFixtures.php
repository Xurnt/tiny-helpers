<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;

use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $this->loadCategory($manager);
        $this->loadUser($manager);
        $this->loadArticle($manager);

    }

    /**
     * Alimenter l'entité Article
     */
    public function loadArticle(ObjectManager $manager)
    {
        // 10 articles
        // On configure faker pour distribuer des données en francais
        $faker = Faker\Factory::create('fr_FR');
        $faker->addProvider(new \EmanueleMinotto\Faker\PlaceholdItProvider($faker));
        $manager->flush();
        for ($i = 1; $i <= 10; $i++) {
            // créer une entité Article
            $article = new Article();
            $article
                ->setName($faker->sentence($faker->numberBetween(4, 10)))
                ->setIllustration($faker->imageUrl('200x200'))
                ->setDescription($faker->sentence());
            $categoryNumber =$faker->numberBetween(1,5);
            for ($j=0; $j < $categoryNumber; $j++) { 
                $article->addCategory($this->getReference("Category_".$faker->numberBetween(1,5)));
            }
            $userNumber =$faker->numberBetween(1,3);
            for ($j=0; $j < $userNumber; $j++) { 
                $article->addUser($this->getReference("User_".$faker->numberBetween(1,3)));
            }
            $manager->persist($article);
        }
        $manager->flush();
    }

    /**
     * Alimenter l'entité Category
     */
    public function loadCategory(ObjectManager $manager)
    {
        // 5 categories
        // On configure faker pour distribuer des données en francais
        $faker = Faker\Factory::create('fr_FR');
        $faker->addProvider(new \EmanueleMinotto\Faker\PlaceholdItProvider($faker));
        $manager->flush();
        for ($i = 1; $i <= 5; $i++) {
            // créer une entité Category
            $category = new Category();
            $category
                ->setName($faker->word);
            $this->addReference("Category_".$i,$category);
            $manager->persist($category);
        }
        $manager->flush();
    }

    /**
     * Alimenter l'entité User
     */
    public function loadUser(ObjectManager $manager)
    {
        // 3 utilisateurs
        // On configure faker pour distribuer des données en francais
        $faker = Faker\Factory::create('fr_FR');
        $faker->addProvider(new \EmanueleMinotto\Faker\PlaceholdItProvider($faker));
        $manager->flush();
        for ($i = 1; $i <= 3; $i++) {
            // créer une entité User
            $user = new User();
            $user
                ->setName($faker->name($gender = null))
                ->setProfilePicture($faker->imageUrl('200x200'))
                ->setLink($faker->url())
                ->setMail($faker->email())
                ->setPassword($faker->password());
            $this->addReference("User_".$i,$user);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
