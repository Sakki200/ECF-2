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
            'room_0.jpg',
            'room_1.jpg',
            'room_2.jpg',
            'room_3.jpg',
            'room_4.jpg',
            'room_5.jpg',
            'room_6.jpg',
            'room_7.jpg',
            'room_8.jpg',
            'room_9.jpg',
            'room_10.jpg',
            'room_11.jpg',
            'room_12.jpg',
            'room_13.jpg',
            'room_14.jpg',
            'room_15.jpg',
            'room_16.jpg',
            'room_17.jpg',
            'room_18.jpg',
            'room_19.jpg'
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
