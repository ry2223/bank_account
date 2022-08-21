<?php

namespace App\Repository;

use App\Entity\Client;
use App\Entity\Money;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Money>
 *
 * @method Money|null find($id, $lockMode = null, $lockVersion = null)
 * @method Money|null findOneBy(array $criteria, array $orderBy = null)
 * @method Money[]    findAll()
 * @method Money[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MoneyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Money::class);
    }

    public function add(Money $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Money $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//     public function findTransactionHistory($value): array
//     {
//         return $this->createQueryBuilder('money')
//             ->join('.client', 'r')
//             ->where('r.foo = 1')
//             ->getQuery()
//             ->getResult()
//         ;
//     }

//     public function findOneBySomeField($value): ?Money
//     {
//         return $this->createQueryBuilder('m')
//             ->andWhere('m.exampleField = :val')
//             ->setParameter('val', $value)
//             ->getQuery()
//             ->getOneOrNullResult()
//         ;
//     }
}
