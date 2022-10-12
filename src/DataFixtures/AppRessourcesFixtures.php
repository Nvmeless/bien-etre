<?php
namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Picture;
use Faker\Generator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppRessourcesFixtures extends Fixture
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
        
        $imagesPath = [
            '6338308732175_Screenshot_2.png',
            'e6f02c117f49a054d2bbddf507497772-63446d8ea4824205215300.png',
            'screenshot-7-63383d41768b9170843456.png'
        ];
        // $imagesPath[array_rand($imagesPath)]
        // //Pictures
        for ($i = 0; $i < 5; $i++) {
        $picture = new Picture();
        $pictureName = $imagesPath[array_rand($imagesPath)];
        $picture->setRealname($pictureName)
            ->setRealPath($pictureName)
            ->setPublicPath("/public/images/pictures")
            ->setMime('image/png')
            ->setUploadDate(new \DateTime());
            // ->setStatus(true);

            $manager->persist($picture);
            $this->addReference('picture_' . $i, $picture);
        }
        

        $manager->flush();
    }

}