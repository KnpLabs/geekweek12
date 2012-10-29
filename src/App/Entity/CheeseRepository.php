<?php

namespace App\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

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

        return $qb
            ->addSelect('(c.totalRating / c.totalVote) AS HIDDEN rating')
            ->orderBy('rating', 'DESC')
        ;
    }

    private function getDistinctMilkQueryBuilder(QueryBuilder $qb = null)
    {
        $qb = $qb === null ? $this->getAllQueryBuilder() : $qb;

        return $qb
            ->select('c.milk')
            ->orderBy('c.milk')
            ->distinct(true)
        ;
    }

    private function getDistinctRegionQueryBuilder(QueryBuilder $qb = null)
    {
        $qb = $qb === null ? $this->getAllQueryBuilder() : $qb;

        return $qb
            ->select('c.region')
            ->orderBy('c.region')
            ->distinct(true)
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

    public function findAllByRegion($region, $sorted = false, $limit = null)
    {
        $qb = $this->getAllByRegionQueryBuilder($region);

        $qb = $sorted ? $this->getAllOrderByRating($qb) : $qb;
        $qb = $limit === null ? $qb : $qb->setMaxResults($limit);

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }

    public function findRegions()
    {
        return $this
            ->getDistinctRegionQueryBuilder()
            ->getQuery()
            ->getResult()
        ;
    }

    public function findMilks()
    {
        return $this
            ->getDistinctMilkQueryBuilder()
            ->getQuery()
            ->getResult()
        ;
    }
}
