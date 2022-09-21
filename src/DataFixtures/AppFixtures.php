<?php
namespace App\DataFixtures;

use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //Ici je manipules des données pour creer mon Event.
        //Les differentes références sont obtensible ici : ../Entity/Event.php
        for ($i = 0; $i < 5; $i++) {
            $event = new Event;
            $event->setEventName("Nom pas très original.");
            $event->setEventDesc('Trouves mieux que ça serieux.');
            $event->setEventStartDate(new \DateTime('09/01/2019'));
            $manager->persist($event);
        }

        $manager->flush();
    }

    //`php bin/console doctrine:fixtures:load ` Execute tes Fixtures.
}