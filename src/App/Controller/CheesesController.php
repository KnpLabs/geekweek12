<?php

namespace App\Controller;

use Knp\RadBundle\Controller\Controller;

class CheesesController extends Controller
{
    public function indexAction()
    {
        return array('cheeses' => $this->getCheeseRepository()->findAll(true, 3));
    }

    public function indexRegionAction($region)
    {
        return array(
            'cheeses' => $this->getCheeseRepository()->findAllByRegion($region, true, 3),
            'region'  => $region,
        );
    }

    public function indexMilkAction($milk)
    {
        return array(
            'cheeses' => $this->getCheeseRepository()->findAllByMilk($milk, true, 3),
            'milk'    => $milk,
        );
    }

    public function showAction($name)
    {
        $cheese = $this->findEntityOr404('App\Entity\Cheese', array('name' => $name));

        return array('cheese' => $cheese);
    }

    public function rateAction($name, $score)
    {
        $cheese = $this->findEntityOr404('App\Entity\Cheese', array('name' => $name));
        $cheese->rate($score);
        $this->getEntityManager()->flush();

        return $this->redirectRoute('show_cheese', array('name' => $name));
    }

    public function listRegionAction()
    {
        return $this->render('App:Cheeses:listRegion.html.twig', array(
            'regions' => $this->getCheeseRepository()->findRegions(),
        ));
    }

    public function listMilkAction()
    {
        return $this->render('App:Cheeses:listMilk.html.twig', array(
            'milks' => $this->getCheeseRepository()->findMilks(),
        ));
    }

    private function getCheeseRepository()
    {
        return $this->getRepository('App\Entity\Cheese');
    }
}
