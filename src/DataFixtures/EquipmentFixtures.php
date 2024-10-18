<?php

namespace App\DataFixtures;

use App\Entity\Equipment;
use App\Entity\RoomEquipment;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;

class EquipmentFixtures extends Fixture implements DependentFixtureInterface
{
    public function __construct() {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $equipmentOptions = [
            'Cable RJ45/Ethernet',
            'Wifi haut débit',
            'Écran de projection',
            'Tableau blanc',
            'Vidéoprojecteur',
            'Système de visioconférence',
            'Prises électriques multiples',
            'Chaises ergonomiques',
            'Tables modulables',
            'Machine à café',
            'Fontaine à eau',
            'Imprimante multifonction',
            'Ordinateur',
            'Chaise de bureau',
            'Cable de connectique'
        ];
        $softwareOptions = [
            'Excel',
            'Word',
            'PowerPoint',
            'Outlook',
            'Google Docs',
            'Slack',
            'Trello',
            'Zoom',
            'Skype',
            'Microsoft Teams',
            'Open Office',
            'LibreOffice',
            'Evernote',
            'Adobe Photoshop',
            'Adobe Illustrator',
            'Adobe InDesign',
            'Adobe Premiere Pro',
            'Adobe After Effects',
            'Adobe Audition',
            'Adobe Lightroom',
            'Visual Studio Code'
        ];

        foreach ($equipmentOptions as $option) {
            $equipment = new Equipment;
            $equipment
                ->setName($option)
                ->setSoftware(false);
            $manager->persist($equipment);
        }
        foreach ($softwareOptions as $option) {
            $equipment = new Equipment;
            $equipment
                ->setName($option)
                ->setSoftware(true);
            $manager->persist($equipment);
        }

        $manager->flush();

        for ($i = 0; $i < $faker->numberBetween(70, 90); $i++) {
            $roomEquipments = new RoomEquipment;
            $room = $this->getReference('room_' . $faker->numberBetween(0, 19));
            $roomEquipments
                ->setRoom($room)
                ->setEquipment($equipment)
                ->setQuantity($faker->numberBetween(1, 5));

            $manager->persist($roomEquipments);
        }
        $manager->flush();
    }


    public function getDependencies()
    {
        return [RoomFixtures::class];
    }
}
