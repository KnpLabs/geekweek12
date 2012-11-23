<?php

namespace App\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Knp\RadBundle\DataFixtures\AbstractFixture;

class LoadWineData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $this->createObjectFactory($manager,  'App\Entity\Wine')
            ->add(['name' => 'Malsan',      'type' => 'Rouge',    'year' => 2006])
            ->add(['name' => 'Jurançon',    'type' => 'Moelleux', 'year' => 2011])
            ->add(['name' => 'Sidi Brahim', 'type' => 'Rosé',     'year' => 2004])
        ;

        $manager->flush();
    }

    public function getOrder()
    {
        return 20;
    }
}
