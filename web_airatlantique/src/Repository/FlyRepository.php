<?php

namespace App\Repository;

use App\Entity\Fly;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Fly|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fly|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fly[]    findAll()
 * @method Fly[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FlyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Fly::class);
    }

    public function findByTrip($hourStart,$trip)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.hour_start > :val ')
            ->andWhere('f.trip_used = :trip')
            ->setParameter('val', $hourStart)
            ->setParameter('trip', $trip)
            ->orderBy('f.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByHourStart($hourStart)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.hour_start > :val')
            ->setParameter('val', $hourStart)
            ->orderBy('f.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByAirportStart($hourStart,$a1,$a2)
    {
        return $this->createQueryBuilder('f')
            ->innerJoin('App\Entity\Trip', 't', \Doctrine\ORM\Query\Expr\Join::WITH, 'f.trip_used=t.id')
            ->andWhere('t.airport_start = :a1')
            ->andWhere('t.airport_end != :a2')
            ->andWhere('f.hour_start > :val')
            ->setParameter('val', $hourStart)
            ->setParameter('a1', $a1)
            ->setParameter('a2', $a2)
            ->orderBy('f.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }


}
