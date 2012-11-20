<?php

namespace App\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOException;

use App\Entity\Cheese;
use Knp\RadBundle\DataFixtures\AbstractFixture;

class LoadCheeseData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $this->createObjectFactory($manager,  'App\Entity\Cheese')
            ->add(['name' => 'Camembert',    'region' => 'Normandie',  'milk' => 'Cow',   'totalRating' => 12*5,  'totalVote' => 12])
            ->add(['name' => 'Gruyère',      'region' => 'Suisse',     'milk' => 'Cow',   'totalRating' => 12*2,  'totalVote' => 12])
            ->add(['name' => 'Maroilles',    'region' => 'Nord',       'milk' => 'Cow',   'totalRating' => 12*2,  'totalVote' => 12])
            ->add(['name' => 'Munster',      'region' => 'Alsace',     'milk' => 'Cow',   'totalRating' => 12*3,  'totalVote' => 12])
            ->add(['name' => 'Ossau-Iraty',  'region' => 'Pyrénées',   'milk' => 'Goat',  'totalRating' => 12*5,  'totalVote' => 12])
            ->add(['name' => 'Roquefort',    'region' => 'Aveyron',    'milk' => 'Goat',  'totalRating' => 12*1,  'totalVote' => 12])
        ;

        $manager->flush();

        $this->moveAsset($this->getReference('Cheese:Camembert'));
        $this->moveAsset($this->getReference('Cheese:Gruyère'));
        $this->moveAsset($this->getReference('Cheese:Maroilles'));
        $this->moveAsset($this->getReference('Cheese:Munster'));
        $this->moveAsset($this->getReference('Cheese:Ossau-Iraty'));
        $this->moveAsset($this->getReference('Cheese:Roquefort'));
    }

    public function getOrder()
    {
        return 10;
    }

    private function moveAsset(Cheese $cheese)
    {
        $fs = new Filesystem();

        $source = sprintf('%s/../Resources/%s.jpg', __DIR__, $cheese->getSluggedName());
        $target = sprintf('%s/../../Resources/public/img/cheeses/%s.jpg', __DIR__, $cheese->getId());

        if ($fs->exists($source)) {
            return $fs->copy($source, $target, true);
        }

        throw new \Exception(sprintf("File '%s' doesn't exists.", $source));
    }
}
