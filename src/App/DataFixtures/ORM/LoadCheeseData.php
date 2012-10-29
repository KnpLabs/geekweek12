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
        

        $cheese = new Cheese();
        $cheese->setName('Gruyère');
        $cheese->setRegion('Suisse');
        $cheese->setMilk('Vache');
        $cheese->setTotalRating(12*2);
        $cheese->setTotalVote(12);

        $manager->persist($cheese);
        

        $cheese = new Cheese();
        $cheese->setName('Maroilles');
        $cheese->setRegion('Nord');
        $cheese->setMilk('Vache');
        $cheese->setTotalRating(12*2);
        $cheese->setTotalVote(12);

        $manager->persist($cheese);
        

        $cheese = new Cheese();
        $cheese->setName('Munster');
        $cheese->setRegion('Nord');
        $cheese->setMilk('Vache');
        $cheese->setTotalRating(12*3);
        $cheese->setTotalVote(12);

        $manager->persist($cheese);
        

        $cheese = new Cheese();
        $cheese->setName('Ossau-Iraty');
        $cheese->setRegion('Pyrenées');
        $cheese->setMilk('Brebis');
        $cheese->setTotalRating(12*5);
        $cheese->setTotalVote(12);

        $manager->persist($cheese);
        

        $cheese = new Cheese();
        $cheese->setName('Roquefort');
        $cheese->setRegion('Aveyron');
        $cheese->setMilk('Brebis');
        $cheese->setTotalRating(12*1);
        $cheese->setTotalVote(12);

        $manager->persist($cheese);

        $manager->flush();
    }
}