<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;
use App\Entity\Cheese;

class CheesesController extends Controller
{
    public function indexAction()
    {
        $cheeses = $this->getRepository('App:Cheese')->findAll(true, 3);

        return array('cheeses' => $cheeses);
    }

    public function adminAction()
    {
        $cheeses = $this->getRepository('App:Cheese')->findAll();

        return array('cheeses' => $cheeses);
    }

    public function newAction(Cheese $cheese, Form $form)
    {
        if ($form->isBound()) {
            $this->persist($cheese, true);
            $this->addFlashf('success', 'Cheese "%s" created.', $cheese->getName());

            return $this->redirectRoute('app_cheeses_show', array('name' => $cheese->getName()));
        }

        return array('form' => $form->createView());
    }

    public function editAction(Cheese $cheese, Form $form)
    {
        if ($form->isBound()) {
            $this->persist($cheese, true);
            $this->addFlashf('success', 'Cheese "%s" updated.', $cheese->getName());

            return $this->redirectRoute('app_cheeses_show', array('name' => $cheese->getName()));
        }

        return array('cheese' => $cheese, 'form' => $form->createView());
    }

    public function deleteAction(Cheese $cheese)
    {
        $this->remove($cheese, true);
        $this->addFlashf('success', 'Cheese "%s" deleted.', $cheese->getName());

        return $this->redirectRoute('app_cheeses_index');
    }

    public function showAction(Cheese $cheese)
    {
        return array('cheese' => $cheese);
    }

    public function rateAction(Cheese $cheese, $score)
    {
        $cheese->rate($score);
        $this->flush();

        return $this->redirectRoute('app_cheeses_show', array('name' => $cheese->getName()));
    }

    public function indexRegionAction($region)
    {
        $cheeses = $this->getRepository('App:Cheese')->findAllByRegion($region, true, 3);

        return array('cheeses' => $cheeses, 'region' => $region);
    }

    public function indexMilkAction($milk)
    {
        $cheeses = $this->getRepository('App:Cheese')->findAllByMilk($milk, true, 3);

        return array('cheeses' => $cheeses, 'milk' => $milk);
    }

    public function listRegionAction()
    {
        $regions = $this->getRepository('App:Cheese')->findAllRegion();

        return array('regions' => $regions);
    }

    public function listMilkAction()
    {
        $milk = $this->getRepository('App:Cheese')->findAllMilk();

        return array('milks' => $milk);
    }
}
