<?php

namespace App\DataFixtures;

use App\Entity\Attractions;
use App\Entity\Notation;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $attraction1 = new Attractions;
        $attraction1->setName('Blanche-Neige et les Sept Nains')
                    ->setDescription("Heigh Ho! Heigh Ho! Découvrez l'histoire de Blanche-Neige et les Sept Nains sous un angle nouveau, en visitant avec vos enfants un pays enchanté. Plongez au cœur du célèbre conte de fées en regardant ce qui se cache dans le miroir de la méchante reine, en traversant avec précaution la forêt hantée et en rendant visite aux sept nains dans leur chaumière.")
                    ->setImage('BlancheNeige.jpg')
        ;
        $manager->persist($attraction1);

        $user1 = new User;
        $user1->setName('Richez')
              ->setSurname('Damien')
              ->setemail('damien.richez1@gmail.com')
              ->setPassword('1234')
        ;
        $manager->persist($user1);

        $note1= new Notation;
        $note1->setIdUser($user1)
              ->setIdAttractions($attraction1)
              ->setNote(10)
              ->setAvis('La meilleure attractions, cast members sympathiques !')
        ;
        $manager->persist($note1);


        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
