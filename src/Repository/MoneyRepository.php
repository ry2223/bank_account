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

    public function showHistory($value): array
    {
        return $this->createQueryBuilder('m')
            ->select('m.id', 'c.name', 'c.accountBalance', 'm.moneyWithdrawal', 'm.moneyDeposit')
            ->from('App\Entity\Client', 'c')    
            ->join('m.client', 'mid', 'mid = c.id')
            ->where('m.client = :value')
            ->setParameter('value', $value)
            ->getQuery()
            ->getResult()
        ;
    }
}
