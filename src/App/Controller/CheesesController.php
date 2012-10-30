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

    public function newAction(Request $request)
    {
        $cheese = new Cheese();
        $form   = $this->get('knp_rad.form.manager')->createFormFor($cheese);

        if ($request->getMethod() === 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $this->persistAndFlush($cheese);

                return $this->redirectRoute('app_cheeses_show', array('name' => $cheese->getName()));
            }
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

        return $this->redirectRoute('app_cheeses_show', array('name' => $name));
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

    protected function getCheeseRepository()
    {
        return $this->getRepository(new Cheese);
    }
}