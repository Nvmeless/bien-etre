<?php
namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use App\Entity\Event;
use App\Entity\Author;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;

    /**
     * Password Hasher
     *
     * @var UserPasswordHasherInterface
     */
    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher){
        $this->faker = Factory::create('fr_FR');
        $this->userPasswordHasher = $userPasswordHasher;
    }
    
    public function load(ObjectManager $manager): void
    {
        // Public
        $publicUser = new User();
        $publicUser->setUsername("public");
        $publicUser->setRoles(["PUBLIC"]);
        $publicUser->setPassword($this->userPasswordHasher->hashPassword($publicUser, "public"));
        $manager->persist($publicUser);


        // Authentifiés
        for ($i = 0; $i < 5; $i++) {
            $userUser = new User();
            $password = $this->faker->password(2, 6);
            $userUser->setUsername($this->faker->userName() . "@". $password);
            $userUser->setRoles(["USER"]);
            $userUser->setPassword($this->userPasswordHasher->hashPassword($userUser, $password));
            $manager->persist($userUser);
        }


        // Admins
        $adminUser = new User();
        $adminUser->setUsername("admin");
        $adminUser->setRoles(["ADMIN"]);
        $adminUser->setPassword($this->userPasswordHasher->hashPassword($adminUser, "password"));
        $manager->persist($adminUser);
   
        $authorList = [];

        for ($i = 0; $i < 5; $i++) {
            $author = new Author;
            $author->setAuthorFirstName($this->faker->firstName())
                ->setAuthorLastName($this->faker->lastName());
            
            $authorList[] = $author; 
            
            $manager->persist($author);
        }

        for ($i = 0; $i < 50; $i++) {
            $event = new Event;
            // $endDate = $this->faker->optional($weight = 0.25)->dateTime($max = 'now');
            $endDate = $this->faker->optional($weight = 0.25)->dateTimeInInterval('-1 week', '+10 week');
            $event->setEventName($this->faker->realText($maxNbChars =30, $indexSize = 2))
            ->setEventDesc($this->faker->text())
            ->setEventPrice($this->faker->optional($weight = 0.25)->randomDigit())
            ->setEventStartDate($this->faker->dateTime($max = $endDate ? $endDate : 'now'))
            ->setEventEndDate($endDate)
            ->setStatus(true)
            ->setAuthor($authorList[array_rand($authorList)]);;

            $manager->persist($event);
        }




        $manager->flush();
    }

    //`php bin/console doctrine:fixtures:load ` Execute tes Fixtures.
}