<?php

namespace App\Repository;

use App\Entity\RepresentationUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method RepresentationUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method RepresentationUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method RepresentationUser[]    findAll()
 * @method RepresentationUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepresentationUserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, RepresentationUser::class);
    }

    // /**
    //  * @return RepresentationUser[] Returns an array of RepresentationUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RepresentationUser
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
