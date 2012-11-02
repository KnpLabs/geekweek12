<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Knp\RadBundle\Controller\Controller;
use App\Entity\Cheese;
use App\Form\EditCheeseType;

class CheesesController extends Controller
{
    public function indexAction()
    {
        return array('cheeses' => $this->getRepository('App:Cheese')->findAll(true, 3));
    }

    public function adminAction(Request $request)
    {
        return array('cheeses' => $this->getRepository('App:Cheese')->findAll());
    }

    public function newAction(Request $request)
    {
        $cheese = new Cheese();
        $form   = $this->createObjectForm($cheese);

        if ($request->getMethod() === 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $this->persist($cheese, true);
                $this->getFlashBag->add('success', sprintf(
                    'Cheese %s created', $cheese->getName()
                ));

                return $this->redirectRoute('app_cheeses_show', array(
                    'name' => $cheese->getName()
                ));
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    public function editAction(Request $request, $name)
    {
        $cheese = $this->findOr404('App:Cheese', array('name' => $name));
        $form   = $this->createObjectForm($cheese);

        if ($request->getMethod() === 'PUT') {
            $form->bind($request);

            if ($form->isValid()) {
                $this->persist($cheese, true);
                $this->getFlashBag()->add('success', sprintf(
                    'Cheese %s updated', $cheese->getName()
                ));

                return $this->redirectRoute('app_cheeses_show', array(
                    'name' => $cheese->getName()
                ));
            }
        }

        return array(
            'cheese' => $cheese,
            'form'   => $form->createView(),
        );
    }

    public function indexRegionAction($region)
    {
        return array(
            'cheeses' => $this->getRepository('App:Cheese')->findAllByRegion($region, true, 3),
            'region'  => $region,
        );
    }

    public function indexMilkAction($milk)
    {
        return array(
            'cheeses' => $this->getRepository('App:Cheese')->findAllByMilk($milk, true, 3),
            'milk'    => $milk,
        );
    }

    public function showAction($name)
    {
        $cheese = $this->findOr404('App:Cheese', array('name' => $name));

        return array('cheese' => $cheese);
    }

    public function rateAction($name, $score)
    {
        $cheese = $this->findOr404('App:Cheese', array('name' => $name));
        $cheese->rate($score);

        $this->flush();

        return $this->redirectRoute('app_cheeses_show', array('name' => $name));
    }

    public function listRegionAction()
    {
        return array(
            'regions' => $this->getRepository('App:Cheese')->findRegions(),
        );
    }

    public function listMilkAction()
    {
        return array(
            'milks' => $this->getRepository('App:Cheese')->findMilks(),
        );
    }
}
