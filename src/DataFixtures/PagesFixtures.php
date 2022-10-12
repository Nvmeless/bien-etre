<?php
namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Atom;
use App\Entity\Wizard;
use App\Repository\PictureRepository;
use Faker\Generator;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PagesFixtures extends Fixture
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
        
        
        $this->quantity = [
            'user_authentified' => 5,
            'picture' => 5,
            'author' => 5,
            'event' => 50,
        ];
    }

    public function autoWireFixtures(){
        $pictureList = [];
        $eventList = [];
        $authorList = [];
        //Pictures
        for ($i=0; $i < $this->quantity['picture'] ; $i++) { 
            $picture = $this->getReference('picture_' . $i);
            $pictureList[$i] = $picture;
        }
          //Events
        for ($i=0; $i < $this->quantity['event'] ; $i++) { 
            $event = $this->getReference('event_' . $i);
            $eventList[$i] = $event;
        }
          //Authors
        for ($i=0; $i < $this->quantity['author'] ; $i++) { 
            $author = $this->getReference('author_' . $i);
            $authorList[$i] = $author;
        }
        $this->ressources = [
            'picture' => $pictureList,
            'author' => $authorList,
            'event' => $eventList,
        ];
    }
    
    public function load(ObjectManager $manager): void
    {
        $this->autoWireFixtures();
        
        $atoms = [];
        
        // //Atoms Text
        for ($i = 0; $i < 5; $i++) {
        $atom = new Atom();
        $atom->setName($this->faker->realText(15))
            ->setContent($this->faker->realText(500))
            ->setStatus(true);

        $manager->persist($atom);
        }

        // //Wizard
            

        // //Atoms Wizard
        for ($i = 0; $i < 5; $i++) {
            $atom = new Atom();
            $atom->setName($this->faker->realText(15))
                ->setContent("wizard.picture")
                ->setStatus(true);

            $atoms[] = $atom;
            $manager->persist($atom);
        }

        for ($i = 0; $i < 5; $i++) {
            $wizard = new Wizard();
            $index = array_rand($atoms);

            $atoms[$index];
            $wizard->addAtom($atoms[array_rand($atoms)])
            ->addPicture($this->ressources['picture'][array_rand($this->ressources['picture'])])
            ->setStatus(true);

            $manager->persist($wizard);
        }

        $atoms = [];
        for ($i = 0; $i < 5; $i++) {
            $atom = new Atom();
            $atom->setName($this->faker->realText(15))
                ->setContent("wizard.events")
                ->setStatus(true);

            $atoms[] = $atom;
            $manager->persist($atom);
        }

        for ($i = 0; $i < 5; $i++) {
            $wizard = new Wizard();
            $index = array_rand($atoms);

            $atoms[$index];
            $wizard->addAtom($atoms[array_rand($atoms)])
            ->addEvent($this->ressources['event'][array_rand($this->ressources['event'])])
            ->setStatus(true);

            $manager->persist($wizard);
        }

        $atoms = [];
        for ($i = 0; $i < 5; $i++) {
            $atom = new Atom();
            $atom->setName($this->faker->realText(15))
                ->setContent("wizard.authors")
                ->setStatus(true);

            $atoms[] = $atom;
            $manager->persist($atom);
        }

        for ($i = 0; $i < 5; $i++) {
            $wizard = new Wizard();
            $index = array_rand($atoms);

            $atoms[$index];
            $wizard->addAtom($atoms[array_rand($atoms)])
            ->addAuthor($this->ressources['author'][array_rand($this->ressources['author'])])
            ->setStatus(true);

            $manager->persist($wizard);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AppRessourcesFixtures::class,
        ];
    }
    //`php bin/console doctrine:fixtures:load ` Execute tes Fixtures.
}