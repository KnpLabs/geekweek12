<?php

namespace App\Entity;

use Knp\RadBundle\Doctrine\EntityRepository;

use Doctrine\ORM\QueryBuilder;

class CheeseRepository extends EntityRepository
{
    public function createNew()
    {
        return new Cheese();
    }

    public function buildAllByRegion($region, QueryBuilder $qb = null)
    {
        $qb = $qb === null ? $this->build() : $qb;

        return $qb
            ->andWhere($this->getAlias().'.region = :whereRegion')
            ->setParameter('whereRegion', $region)
        ;
    }


    public function buildAllByMilk($milk, QueryBuilder $qb = null)
    {
        $qb = $qb === null ? $this->build() : $qb;

        return $qb
            ->andWhere($this->getAlias().'.milk = :whereMilk')
            ->setParameter('whereMilk', $milk)
        ;
    }

    public function buildAllOrderByRating(QueryBuilder $qb = null)
    {

        $qb = $qb === null ? $this->build() : $qb;

        return $qb
            ->addSelect(sprintf('(%s.totalRating / %s.totalVote) AS HIDDEN rating', $this->getAlias(), $this->getAlias()))
            ->orderBy('rating', 'DESC')
        ;
    }

    public function buildAllMilk(QueryBuilder $qb = null)
    {
        $qb = $qb === null ? $this->build() : $qb;

        return $qb
            ->select($this->getAlias().'.milk')
            ->orderBy($this->getAlias().'.milk')
            ->distinct(true)
        ;
    }

    public function buildAllRegion(QueryBuilder $qb = null)
    {
        $qb = $qb === null ? $this->build() : $qb;

        return $qb
            ->select($this->getAlias().'.region')
            ->orderBy($this->getAlias().'.region')
            ->distinct(true)
        ;
    }

    public function findAll($sorted = false, $limit = null)
    {
        $qb = $this->build();

        $qb = $sorted ? $this->buildAllOrderByRating($qb) : $qb;
        $qb = $limit === null ? $qb : $qb->setMaxResults($limit);

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllByMilk($milk, $sorted = false, $limit = null)
    {
        $qb = $this->buildAllByMilk($milk);

        $qb = $sorted ? $this->buildAllOrderByRating($qb) : $qb;
        $qb = $limit === null ? $qb : $qb->setMaxResults($limit);

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllByRegion($region, $sorted = false, $limit = null)
    {
        $qb = $this->buildAllByRegion($region);

        $qb = $sorted ? $this->buildAllOrderByRating($qb) : $qb;
        $qb = $limit === null ? $qb : $qb->setMaxResults($limit);

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }
}
