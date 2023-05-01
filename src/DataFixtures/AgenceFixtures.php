<?php

namespace App\DataFixtures;

use App\Entity\Agence;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AgenceFixtures extends Fixture
{

    public function __construct(
        private UserPasswordHasherInterface $passwordEndcoder,
    )
    {
        
    }

    public function load(ObjectManager $manager): void
    {
        $agenceDemo = new Agence();
        $agenceDemo->setNom('Agence Démo');
        $agenceDemo->setEmail('agencedemo@gmail.com');
        $agenceDemo->setFrais('8');
        $agenceDemo->setPassword(
            $this->passwordEndcoder->hashPassword($agenceDemo, 'azerty')
        );
        $agenceDemo->setRoles(['ROLE_ADMIN']);


        $manager->persist($agenceDemo);
        $manager->flush();


        $this->addReference('agenceDemo', $agenceDemo);
    }
}
