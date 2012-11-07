<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Cheese;

class CheesesController extends Controller
{
    public function indexAction()
    {
        $cheeses = $this->getRepository('App:Cheese')->findAll(true, 3);

        return ['cheeses' => $cheeses];
    }

    public function adminAction(Request $request)
    {
        $cheeses = $this->getRepository('App:Cheese')->findAll();

        return ['cheeses' => $cheeses];
    }

    public function newAction(Request $request)
    {
        $cheese = new Cheese();
        $form   = $this->createObjectForm($cheese, 'new');

        if ('POST' === $request->getMethod() && $form->bind($request)->isValid()) {
            $this->persist($cheese, true);
            $this->addFlashf('success', 'Cheese "%s" created.', $cheese->getName());

            return $this->redirectRoute('app_cheeses_show', ['name' => $cheese->getName()]);
        }

        return ['form' => $form->createView()];
    }

    public function editAction(Request $request, $name)
    {
        $cheese = $this->findOr404('App:Cheese', ['name' => $name]);
        $form   = $this->createObjectForm($cheese, 'edit');

        if ('PUT' === $request->getMethod() && $form->bind($request)->isValid()) {
            $this->persist($cheese, true);
            $this->addFlashf('success', 'Cheese "%s" updated.', $cheese->getName());

            return $this->redirectRoute('app_cheeses_show', ['name' => $cheese->getName()]);
        }

        return ['cheese' => $cheese, 'form' => $form->createView()];
    }

    public function deleteAction(Request $request, $name)
    {
        $cheese = $this->findOr404('App:Cheese', ['name' => $name]);

        $this->remove($cheese, true);
        $this->addFlashf('success', 'Cheese "%s" deleted.', $cheese->getName());

        return $this->redirectRoute('app_cheeses_index');
    }

    public function indexRegionAction($region)
    {
        $cheeses = $this->getRepository('App:Cheese')->findAllByRegion($region, true, 3);

        return ['cheeses' => $cheeses, 'region' => $region];
    }

    public function indexMilkAction($milk)
    {
        $cheeses = $this->getRepository('App:Cheese')->findAllByMilk($milk, true, 3);

        return ['cheeses' => $cheeses, 'milk' => $milk];
    }

    public function showAction($name)
    {
        $cheese = $this->findOr404('App:Cheese', ['name' => $name]);

        return ['cheese' => $cheese];
    }

    public function rateAction($name, $score)
    {
        $cheese = $this->findOr404('App:Cheese', ['name' => $name]);
        $cheese->rate($score);

        $this->flush();

        return $this->redirectRoute('app_cheeses_show', ['name' => $name]);
    }

    public function listRegionAction()
    {
        $regions = $this->getRepository('App:Cheese')->findAllRegion();

        return ['regions' => $regions];
    }

    public function listMilkAction()
    {
        $milk = $this->getRepository('App:Cheese')->findAllMilk();

        return ['milks' => $milk];
    }
}
