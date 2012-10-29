<?php

namespace App\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Cheese;

class LoadCheeseData implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $cheese = new Cheese();
        $cheese->setName('Camembert');
        $cheese->setRegion('Normandie');
        $cheese->setMilk('Vache');
        $cheese->setTotalRating(12*5);
        $cheese->setTotalVote(12);

        $manager->persist($cheese);

        $manager->flush();
    }
}