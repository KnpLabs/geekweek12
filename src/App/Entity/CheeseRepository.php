<?php

namespace App\Entity;

use Doctrine\ORM\EntityRepository;
use octrine\ORM\QueryBuilder;

class CheeseRepository extends EntityRepository
{

    private function getAllQueryBuilder(QueryBuilder $qb = null)
    {
        return $this
            ->createQueryBuilder('c')
            ->select('c')
        ;
    }

    private function getAllByRegionQueryBuilder($region, QueryBuilder $qb = null)
    {
        $qb = $qb === null ? $this->getAllQueryBuilder() : $qb;

        return $qb
            ->addWhere('UCASE(c.region = :whereRegion')
            ->setParameter('whereRegion', strtoupper($region))
        ;
    }


    private function getAllByMilkQueryBuilder($milk, QueryBuilder $qb = null)
    {
        $qb = $qb === null ? $this->getAllQueryBuilder() : $qb;

        return $qb
            ->addWhere('UCASE(c.milk = :whereMilk')
            ->setParameter('whereMilk', strtoupper($milk))
        ;
    }

    private function getAllOrderByRating(QueryBuilder $qb = null)
    {
        $qb = $qb === null ? $this->getAllQueryBuilder() : $qb;

        $qb
            ->addSelect('(c.totalRating / c.totalVote) AS rating')
            ->orderBy('rating', 'DESC')
        ;
    }

    public function findAll($sorted = false, $limit = null)
    {
        $qb = $this->getAllQueryBuilder();

        $qb = $sorted ? $this->getAllOrderByRating($qb) : $qb;
        $qb = $limit === null ? $qb : $qb->setMaxResults($limit);

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllByMilk($milk, $sorted = false, $limit = null)
    {
        $qb = $this->getAllByMilkQueryBuilder($milk);

        $qb = $sorted ? $this->getAllOrderByRating($qb) : $qb;
        $qb = $limit === null ? $qb : $qb->setMaxResults($limit);

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllByRegion($region, $sorted = false)
    {
        $qb = $this->getAllByRegionQueryBuilder($milk);

        $qb = $sorted ? $this->getAllOrderByRating($qb) : $qb;
        $qb = $limit === null ? $qb : $qb->setMaxResults($limit);

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }

    public function findRegions()
    {
        $qb = $this->getAllQueryBuilder();

        $qb
            ->select('c.region')
            ->distinct(true)
        ;

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }

    public function findMilks()
    {
        $qb = $this->getAllQueryBuilder();

        $qb
            ->select('c.milk')
            ->distinct(true)
        ;

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }
}
