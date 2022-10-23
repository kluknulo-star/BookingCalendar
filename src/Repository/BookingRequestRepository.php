<?php

namespace App\Repository;

use App\Entity\BookingRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BookingRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookingRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookingRequest[]    findAll()
 * @method BookingRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookingRequest::class);
    }

    public function findAllUnseen() : Query
    {

        $queryBuilder = $this->createQueryBuilder('booking')
            ->where('booking.is_approved is NULL')
            ->orderBy('booking.id');

        $query = $queryBuilder->getQuery();

        return $query;
//        return $query->execute();
    }

    public function findAllSeen() : array
    {

        $queryBuilder = $this->createQueryBuilder('booking')
            ->where('booking.is_approved is NOT NULL')
            ->orderBy('booking.id');

        $query = $queryBuilder->getQuery();

        return $query->execute();
    }


}
