<?php

namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Logement;
use Faker;
use Symfony\Bundle\SecurityBundle\Security;

class LogementFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {

        $agence = $this->getReference('agenceDemo');
        $faker = Faker\Factory::create('fr_FR');


        for($l = 1; $l <= 5; $l++){
            $logement = new Logement();
            $logement->setAdresse($faker->streetAddress);
            $logement->setComplement($faker->secondaryAddress);
            $logement->setVille($faker->city);
            $logement->setCodePostal(substr(str_replace(' ', '', $faker->postcode), 0, 5));
            $logement->setMontantLoyer($faker->numberBetween(250, 10000));
            $logement->setCharges($faker->numberBetween(50, 350));
            $logement->setMontantDepotGarantie(($faker->numberBetween(250, 10000)));
            $logement->setGestion($faker->boolean);
            $logement->setAgenceId($agence);
            
            $manager->persist($logement);
        }
        dump($logement);
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            AgenceFixtures::class,
        ];
    }


}
