<?php

namespace App\DataFixtures;

use App\Entity\ergonomic;
use App\Entity\Roomergonomic;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ErgonomicFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct() {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $ergonomic = new Ergonomic;
        $roomergonomics = new RoomErgonomic;


        $ergonomicOptions = [
            'Lumière naturelle',
            'Fenêtre ouvrante',
            'Chauffage',
            'Climatisation',
            'Accessibilité PMR',
            'Lumière ajustable',
            'Insonorisation',
            'Porte à manteau',
            'VMC'
        ];

        foreach ($ergonomicOptions as $option) {
            $ergonomic->setName($option);
            $manager->persist($ergonomic);
            $manager->flush();
        }

        for ($i = 0; $i < $faker->numberBetween(30, 60); $i++) {
            $room = $this->getReference('room_' . $faker->numberBetween(0, 19));
            $roomergonomics->setRoom($room);
            $roomergonomics->setergonomic($ergonomic);

            $manager->persist($roomergonomics);
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [RoomFixtures::class];
    }
}
