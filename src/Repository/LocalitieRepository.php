<?php

namespace App\Repository;

use App\Entity\Localitie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Localitie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Localitie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Localitie[]    findAll()
 * @method Localitie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocalitieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Localitie::class);
    }

    // /**
    //  * @return Localitie[] Returns an array of Localitie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Localitie
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
