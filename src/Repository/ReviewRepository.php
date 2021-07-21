<?php

namespace App\Repository;

use App\Entity\Review;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DateTime;

/**
 * @method Review|null find($id, $lockMode = null, $lockVersion = null)
 * @method Review|null findOneBy(array $criteria, array $orderBy = null)
 * @method Review[]    findAll()
 * @method Review[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReviewRepository extends ServiceEntityRepository
{
    const DAILY = 'daily';
    const WEEKLY = 'weekly';
    const MONTHLY = 'monthly';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    public function analysis(int $hotelId, DateTime $from, DateTime $to, string $mode): array
    {
        $DatePoint = $this->getDateColumnPerMode($mode);

        return $this->createQueryBuilder('r')
            ->andWhere('r.hotel_id = :hotel_id')
            ->andWhere('r.created_date BETWEEN :from AND :to')
            ->setParameter('hotel_id', $hotelId)
            ->setParameter('from', $from->format('Y-m-d 00:00:00.000'))
            ->setParameter('to', $to->format('Y-m-d 23:59:59.999'))
            ->select("$DatePoint date_point", 'COUNT(r.id) review_count', 'AVG(r.score) average_score', "'$mode' mode")
            ->groupBy('date_point')
            ->orderBy('date_point', 'ASC')
            ->getQuery()
            ->getArrayResult();
    }

    private function getDateColumnPerMode(string $mode): string
    {
        switch ($mode) {
            case self::DAILY:
                return 'DATE(r.created_date)';
            case self::WEEKLY:
                return 'YEARWEEK(r.created_date)';
            case self::MONTHLY:
            default:
                return 'DATE_FORMAT(r.created_date, \'%Y-%m-01\')';
        }
    }
}
