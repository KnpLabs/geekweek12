<?php

namespace spec\Knp\RadBundle\Form;

use PHPSpec2\ObjectBehavior;
use App\Entity\Cheese;

class FormManager extends ObjectBehavior
{
    /**
     * @param Symfony\Component\Form\FormFactory $factory
     */
    public function let($factory)
    {
        $this->beConstructedWith($factory);
    }

    /**
     * @param App\Entity\Cheese $cheese
     */
    public function it_should_create_form_from_an_entity_instance($cheese)
    {
        $this->createFormFor($cheese)->shouldHaveType('App\Form\CheeseType');
    }
}
