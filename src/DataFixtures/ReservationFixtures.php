<?php

namespace App\DataFixtures;

use App\Entity\Reservation;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ReservationFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct() {
        ini_set('memory_limit', '512M');
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $hourNumber = [9, 10, 11, 12, 13, 14, 15, 16, 17, 18];
      
        for ($i = 0; $i < 20; $i++) {

            $room = $this->getReference('room_' . $i);

            for ($j = 0; $j < $faker->numberBetween(3, 6); $j++) {
                $setHour = $faker->randomElement($hourNumber);

                $dateTime = $faker->dateTimeBetween('now', '+1 month');

                $reservation = new Reservation;
                $reservation
                    ->setStart($setHour)
                    ->setEndReservation($setHour + $faker->numberBetween(1, 4))
                    ->setValidated("pending")
                    ->setDateReservation($dateTime->setTime(0, 0, 0))
                    ->setUser($this->getReference('user_' . $faker->numberBetween(0, 29)))
                    ->setRoom($room)
                ;

                $manager->persist($reservation);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [RoomFixtures::class, UserFixtures::class];
    }
}
