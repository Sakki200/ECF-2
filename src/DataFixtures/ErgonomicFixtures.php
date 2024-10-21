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

        $arrayErgonomics = [];

        foreach ($ergonomicOptions as $option) {
            $ergonomic = new Ergonomic;
            $ergonomic->setName($option);
            array_push($arrayErgonomics, $ergonomic);
            $manager->persist($ergonomic);
        }
        $manager->flush();

        for ($i = 0; $i < $faker->numberBetween(30, 60); $i++) {
            $roomergonomics = new RoomErgonomic;
            $room = $this->getReference('room_' . $faker->numberBetween(0, 19));
            $roomergonomics
                ->setRoom($room)
                ->setergonomic($faker->randomElement($arrayErgonomics));

            $manager->persist($roomergonomics);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [RoomFixtures::class];
    }
}
