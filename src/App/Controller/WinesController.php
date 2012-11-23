<?php

namespace App\Controller;

class WinesController extends Controller
{
    public function indexAction()
    {
        $wines = $this->getRepository('App:Wine')->findAll();

        return array('wines' => $wines);
    }
}
