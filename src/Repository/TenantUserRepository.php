<?php

namespace App\Repository;

use App\Entity\TenantUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TenantUser>
 *
 * @method TenantUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method TenantUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method TenantUser[]    findAll()
 * @method TenantUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TenantUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TenantUser::class);
    }

//    /**
//     * @return TenantUser[] Returns an array of TenantUser objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TenantUser
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
