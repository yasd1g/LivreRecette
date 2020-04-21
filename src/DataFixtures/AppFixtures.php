<?php

namespace App\DataFixtures;


use App\Entity\Comment;
use App\Entity\Image;
use App\Entity\Recipe;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    /**
     * AppFixtures constructor.
     *
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        // création des utilisateurs

        $users = [];
        $genres = ['male', 'female'];

        for ($i = 1; $i <= 10; $i++){

            $user = new User();

            $genre = $faker->randomElement($genres);
            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1,99) . '.jpg';

            if ($genre == 'male'){
                $picture = $picture . 'men/' . $pictureId;
            }else{
                $picture = $picture . 'women/' . $pictureId;
            }

            $hash = $this->encoder->encodePassword($user, 'password');

            $user->setFirstName($faker->firstName($genre))
                ->setLastName($faker->lastName)
                ->setPicture($picture)
                ->setEmail($faker->email)
                ->setIntroduction($faker->sentence())
                ->setDescription('<p>' . join('</p><p>', $faker->paragraphs(3)) . '</p>')
                ->setHash($hash)
            ;
            $manager->persist($user);

            $users[] = $user;
        }

        // création des recettes

        $categorgies = ['surcé','salé'];

        for ($j = 1; $j <= 30; $j++){

            $recipe = new Recipe();

            $user = $users[mt_rand(0, count($users) - 1)];

            $title = $faker->sentence;
            $introduction = $faker->paragraph;
            $image = "https://picsum.photos/1200/350?random=" . mt_rand(1, 55000);
            $category = array_rand($categorgies,1);
            $difficulty = mt_rand(1,4);
            $realization = '<p>' . join('</p><p>' , $faker->paragraphs(4)) . '</p>';
            $ingredients = '<p>' . join('</p><p>' , $faker->paragraphs(3)) . '</p>';
            $cookingTime = mt_rand(1,240);
            $preparationTime = mt_rand(1,240);
            $thermostat = mt_rand(5,25)*10;

            $recipe->setTitle($title)
                ->setIntroduction($introduction)
                ->setCoverImage($image)
                ->setCategory($category)
                ->setDifficulty($difficulty)
                ->setRealization($realization)
                ->setIngredients($ingredients)
                ->setCookingTime($cookingTime)
                ->setPreparationTime($preparationTime)
                ->setThermostat($thermostat)
                ->setNbOfPersons(mt_rand(1,10))
                ->setAuthor($user)
            ;

            // création des images

                for ($k = 1; $k <= mt_rand(2,5); $k++ ){

                    $images = new Image();

                    $images->setUrl("https://picsum.photos/640/480?random=" . mt_rand(0, 55000))
                        ->setCaption($faker->sentence)
                        ->setRecipe($recipe)
                    ;

                    $manager->persist($images);
                }

            // création des commentaires

                for ($i = 1; $i <= 10; $i++){

                    $comment = new Comment();
                    $comment->setContent($faker->paragraph)
                        ->setAuthor($user)
                        ->setRating(mt_rand(0,5))
                        ->setRecipe($recipe)
                    ;
                    $manager->persist($comment);
                }
            $manager->persist($recipe);
        }

        $manager->flush();
    }
}
















