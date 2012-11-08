<?php

namespace App\Menu;

use Knp\Menu\FactoryInterface;

class Menu
{
    public function navbar(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'childrenAttributes' => array('class' => 'nav')
        ));
        $menu->addChild('Home', array('route' => 'app_cheeses_index'));
        $menu->addChild('Administration', array('route' => 'app_cheeses_admin'));
        $menu->addChild('Add new cheese', array('route' => 'app_cheeses_new'));

        return $menu;
    }
}
