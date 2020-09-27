<?php

namespace App\Repository;

use App\Entity\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Search|null find($id, $lockMode = null, $lockVersion = null)
 * @method Search|null findOneBy(array $criteria, array $orderBy = null)
 * @method Search[]    findAll()
 * @method Search[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Search::class);
    }

    public function findOneByWord($value): ?Search
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.word = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAllUniqueWord(): array
    {
        $qb = $this->createQueryBuilder('p')
            ->addSelect('count(p.id) as count')
            ->addOrderBy('count', 'DESC')
            ->groupBy('p.word');

        $query = $qb->getQuery();

        return $query->execute();
    }
}
