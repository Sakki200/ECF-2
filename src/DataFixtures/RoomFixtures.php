<?php

namespace App\DataFixtures;

use App\Entity\Room;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class RoomFixtures extends Fixture
{
    public function __construct() {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $roomName = [
            'Salle Neptune',
            'Salle Orion',
            'Salle Titan',
            'Salle Andromède',
            'Salle Vega',
            'Salle Cassiopée',
            'Salle Sirius',
            'Salle Antarès',
            'Salle Polaris',
            'Salle Céphée',
            'Salle Lyra',
            'Salle Proxima',
            'Salle Rigel',
            'Salle Alpha',
            'Salle Beta',
            'Salle Galaxia',
            'Salle Cosmos',
            'Salle Nova',
            'Salle Supernova',
            'Salle Horizon'
        ];

        $roomImg = [
            'room0.jpg',
            'room1.jpg',
            'room2.jpg',
            'room3.jpg',
            'room4.jpg',
            'room5.jpg',
            'room6.jpg',
            'room7.jpg',
            'room8.jpg',
            'room9.jpg',
            'room10.jpg',
            'room11.jpg',
            'room12.jpg',
            'room13.jpg',
            'room14.jpg',
            'room15.jpg',
            'room16.jpg',
            'room17.jpg',
            'room18.jpg',
            'room19.jpg'
        ];

        for ($i = 0; $i < 20; $i++) {
            $room = new Room;
            $room
                ->setName($roomName[$i])
                ->setDoorNumber($faker->numberBetween(100, 499))
                ->setFloor($faker->numberBetween(1, 4))
                ->setCapacity($faker->numberBetween(4, 20))
                ->setImage($roomImg[$i])
                ->setBackup($faker->boolean(20));

            $manager->persist($room);
            $this->addReference('room_' . $i, $room);
        }
        $manager->flush();
    }
}
