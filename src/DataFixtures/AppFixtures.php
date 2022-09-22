<?php
namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker;

    public function __construct(){
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        //Ici je manipules des données pour creer mon Event.
        //Les differentes références sont obtensible ici : ../Entity/Event.php
        for ($i = 0; $i < 5; $i++) {
            $event = new Event;
            $endDate = $this->faker->optional($weight = 0.25)->dateTime($max = 'now');
            $event->setEventName($this->faker->realText($maxNbChars =30, $indexSize = 2))
            ->setEventDesc($this->faker->text())
            ->setEventPrice($this->faker->optional($weight = 0.25)->randomDigit())
            ->setEventStartDate($this->faker->dateTime($max = $endDate ? $endDate : 'now'))
            ->setEventEndDate($endDate);

            $manager->persist($event);
        }

        $manager->flush();
    }

    //`php bin/console doctrine:fixtures:load ` Execute tes Fixtures.
}