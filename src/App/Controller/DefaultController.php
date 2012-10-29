<?php

namespace App\Controller;

use Knp\RadBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return array('name' => $name);
    }
}
