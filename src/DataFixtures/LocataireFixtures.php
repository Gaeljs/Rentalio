<?php

namespace App\DataFixtures;

use App\Entity\Locataire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;


class LocataireFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $locataire = new Locataire();
        $locataire->setNom('Nomtest');
        $locataire->setPrenom('Prenomtest');
        $locataire->setAdresse('Adresse de test');
        $locataire->setTelephone('0788094879');
        $locataire->setEmail('maildulocataire@test.com');
        $manager->persist($locataire);

        $manager->flush();

        $locataire = new Locataire();
        $locataire->setNom('Naruto');
        $locataire->setPrenom('Uzumaki');
        $locataire->setAdresse('10 rue de konoha');
        $locataire->setTelephone('0788094859');
        $locataire->setEmail('naruto@test.com');
        $manager->persist($locataire);


        $faker = Faker\Factory::create('fr_FR');
        for($i = 1; $i <= 5; $i++){
            $locataire = new Locataire();
            $locataire->setNom($faker->lastname);
            $locataire->setPrenom($faker->firstname);
            $locataire->setAdresse($faker->streetAddress);
            $locataire->setTelephone(substr(str_replace(' ', '', $faker->phoneNumber), 0, 10));
            $locataire->setEmail($faker->email);
            $manager->persist($locataire);
        }
        dump($locataire);
        $manager->flush();
    }
}
