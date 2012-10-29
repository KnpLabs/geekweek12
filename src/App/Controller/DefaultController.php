<?php

namespace App\Controller;

use Knp\RadBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $repository = $this->getDoctrine()->getEntityManager()->getRepository('App\Entity\Cheese');

        $cheeses = $repository->findAll(true, 3);
        $regions = $repository->findRegions();
        $milks   = $repository->findMilks();

        return array(
            'cheeses' => $cheeses,
            'regions' => $regions,
            'milks'   => $milks,
        );
    }
}
