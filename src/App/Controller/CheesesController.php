<?php

namespace App\Controller;

use Knp\RadBundle\Controller\Controller;

class CheesesController extends Controller
{
    public function indexAction()
    {
        return array('cheeses' => $this->getRepository()->findAll(true, 3));
    }

    public function indexRegionAction($region)
    {
        return array(
            'cheeses' => $this->getRepository()->findAllByRegion($region, true, 3),
            'region'  => $region,
        );
    }

    public function indexMilkAction($milk)
    {
        return array(
            'cheeses' => $this->getRepository()->findAllByMilk($milk, true, 3),
            'milk'    => $milk,
        );
    }

    public function showAction($name)
    {
        $cheese = $this->findOneCheeseOr404($name);

        return array('cheese' => $cheese);
    }

    public function rateAction($name, $score)
    {
        $cheese = $this->findOneCheeseOr404($name);
        $cheese->rate($score);
        $this->getEntityManager()->flush();

        return $this->redirectRoute('show_cheese', array('name' => $name));
    }

    public function listRegionAction()
    {
        return $this->render('App:Cheeses:listRegion.html.twig', array(
            'regions' => $this->getRepository()->findRegions(),
        ));
    }

    public function listMilkAction()
    {
        return $this->render('App:Cheeses:listMilk.html.twig', array(
            'milks' => $this->getRepository()->findMilks(),
        ));
    }

    private function findOneCheeseOr404($name)
    {
        $cheese = $this->getRepository()->findOneByName($name);

        if (!$cheese) {
            throw $this->createNotFoundException(sprintf('Couldn\'t find cheese %s', $name));
        }

        return $cheese;
    }
}
