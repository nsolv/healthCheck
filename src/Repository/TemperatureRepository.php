<?php

namespace App\Repository;

use App\Entity\Temperature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Temperature|null find($id, $lockMode = null, $lockVersion = null)
 * @method Temperature|null findOneBy(array $criteria, array $orderBy = null)
 * @method Temperature[]    findAll()
 * @method Temperature[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TemperatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Temperature::class);
    }

    public function findAVGByPart($groupBySecound, $limit = 3600)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "
            SELECT strftime('%Y-%m-%d %H:%M', part * :groupBySecound, 'unixepoch') ts, avg(value) avg
            FROM (
                SELECT ts, value, strftime('%s', ts) / :groupBySecound part, row_number() OVER(PARTITION BY strftime('%M', ts) / 5)
                FROM temperature
                ORDER BY ts DESC
                LIMIT :limit
            )
            GROUP BY part
        ";
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['groupBySecound' => $groupBySecound, 'limit' => $limit]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }


    // /**
    //  * @return Temperature[] Returns an array of Temperature objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Temperature
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
