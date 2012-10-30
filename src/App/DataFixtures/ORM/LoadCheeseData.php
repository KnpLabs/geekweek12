<?php

namespace App\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Cheese;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;

class LoadCheeseData implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {

        $cheese = new Cheese();
        $cheese->setName('Camembert');
        $cheese->setRegion('Normandie');
        $cheese->setMilk('Cow');
        $cheese->setTotalRating(12*5);
        $cheese->setTotalVote(12);

        $manager->persist($cheese);
        $manager->flush();
        $this->moveAsset($cheese);

        $cheese = new Cheese();
        $cheese->setName('Gruyère');
        $cheese->setRegion('Suisse');
        $cheese->setMilk('Cow');
        $cheese->setTotalRating(12*2);
        $cheese->setTotalVote(12);

        $manager->persist($cheese);
        $manager->flush();
        $this->moveAsset($cheese);

        $cheese = new Cheese();
        $cheese->setName('Maroilles');
        $cheese->setRegion('Nord');
        $cheese->setMilk('Cow');
        $cheese->setTotalRating(12*2);
        $cheese->setTotalVote(12);

        $manager->persist($cheese);
        $manager->flush();
        $this->moveAsset($cheese);

        $cheese = new Cheese();
        $cheese->setName('Munster');
        $cheese->setRegion('Nord');
        $cheese->setMilk('Cow');
        $cheese->setTotalRating(12*3);
        $cheese->setTotalVote(12);

        $manager->persist($cheese);
        $manager->flush();
        $this->moveAsset($cheese);

        $cheese = new Cheese();
        $cheese->setName('Ossau-Iraty');
        $cheese->setRegion('Pyrenées');
        $cheese->setMilk('Goat');
        $cheese->setTotalRating(12*5);
        $cheese->setTotalVote(12);

        $manager->persist($cheese);
        $manager->flush();
        $this->moveAsset($cheese);

        $cheese = new Cheese();
        $cheese->setName('Roquefort');
        $cheese->setRegion('Aveyron');
        $cheese->setMilk('Goat');
        $cheese->setTotalRating(12*1);
        $cheese->setTotalVote(12);

        $manager->persist($cheese);
        $manager->flush();
        $this->moveAsset($cheese);

    }

    private function moveAsset(Cheese $cheese)
    {
        $fs = new Filesystem();

        $source = sprintf('%s/../Resources/%s.jpg', dirname(__FILE__), strtolower($cheese->getName()));
        $target = sprintf('%s/../../Resources/public/img/cheeses/%s.jpg', dirname(__FILE__), $cheese->getId());

        if($fs->exists($source)){
            $fs->copy($source, $target, true);
            return;
        }

        throw new \Exception(sprintf("File '%s' doesn't exists.", $source));
        

    }
}
