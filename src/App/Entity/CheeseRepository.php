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
            ->distinct(true)
        ;
    }

    private function getAllWhereRegionQueryBuilder($region, QueryBuilder $qb = null)
    {
        $qb = $qb === null ? $this->getAllQueryBuilder() : $qb;

        return $qb
            ->addWhere('UCASE(c.region = :whereRegion')
            ->setParameter('whereRegion', strtoupper($region))
        ;
    }


    private function getAllWhereMilkQueryBuilder($milk, QueryBuilder $qb = null)
    {
        $qb = $qb === null ? $this->getAllQueryBuilder() : $qb;

        return $qb
            ->addWhere('UCASE(c.milk = :whereMilk')
            ->setParameter('whereMilk', strtoupper($milk))
        ;
    }

    public function getAllOrderByRating(QueryBuilder $qb = null)
    {
        $qb = $qb === null ? $this->getAllQueryBuilder() : $qb;

        $qb
            ->addSelect('(c.totalRating / c.totalVote) AS rating')
            ->orderBy('rating')
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
        $qb = $this->getAllWhereMilkQueryBuilder($milk);

        $qb = $sorted ? $this->getAllOrderByRating($qb) : $qb;
        $qb = $limit === null ? $qb : $qb->setMaxResults($limit);

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllByRegion($region, $sorted = false)
    {
        $qb = $this->getAllWhereRegionQueryBuilder($milk);

        $qb = $sorted ? $this->getAllOrderByRating($qb) : $qb;
        $qb = $limit === null ? $qb : $qb->setMaxResults($limit);

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }

}
