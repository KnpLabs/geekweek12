<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Knp\RadBundle\Controller\Controller;
use App\Entity\Cheese;

class CheesesController extends Controller
{
    public function indexAction()
    {
        return array('cheeses' => $this->getCheeseRepository()->findAll(true, 3));
    }

    public function newAction()
    {
        $form = $this->get('knp_rad.form.manager')->createFormFor(new Cheese());

        return array(
            'form' => $form->createView(),
        );
    }

    public function createAction(Request $request)
    {
        $cheese = new Cheese();

        $form = $this->get('knp_rad.form.manager')->createFormFor($cheese);

        $form->bind($request);

        if($form->isValid()){


            $this->persistAndFlush($cheese);
            return $this->redirectRoute('show_cheese', array('name' => $cheese->getName()));

        }

        return $this->render('App:Cheeses:new.html.twig', array(
            'form' => $form->createView(),
        ));
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
        return $this->render('App:Cheese:listRegion.html.twig', array(
            'regions' => $this->getRepository()->findRegions(),
        ));
    }

    public function listMilkAction()
    {
        return $this->render('App:Cheese:listMilk.html.twig', array(
            'milks' => $this->getRepository()->findMilks(),
        ));
    }

    protected function getRepository()
    {
        return $this->getDoctrine()->getEntityManager()->getRepository('App\Entity\Cheese');
    }
}
