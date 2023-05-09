<?php

namespace App\Repository;

use App\Entity\Paiement;
use App\Entity\Contrat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contrat>
 *
 * @method Contrat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contrat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contrat[]    findAll()
 * @method Contrat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContratRepository extends ServiceEntityRepository
{



    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contrat::class);
    }

    public function save(Contrat $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Contrat $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Contrat[] Returns an array of Contrat objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Contrat
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function getTotalSolde(): float
    {
        $contrats = $this->findAll();
        $totalSolde = 0;

        foreach ($contrats as $contrat) {
            $paiements = $contrat->getPaiements();

            foreach ($paiements as $paiement) {
                $totalSolde += $paiement->getMontant();
            }
        }

        return $totalSolde;
    }

    public function getSoldesById(): array
    {
        $contrats = $this->findAll();
        $soldesById = [];

        foreach ($contrats as $contrat) {
            $paiements = $contrat->getPaiements();
            $solde = 0;

            foreach ($paiements as $paiement) {
                $solde += $paiement->getMontant();
            }

            $soldesById[$contrat->getId()] = $solde;
        }

        return $soldesById;
    }



}
