<?php

namespace spec\Knp\RadBundle\Form;

use PHPSpec2\ObjectBehavior;

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
    public function it_should_create_form_from_an_entity_instance($cheese, $factory)
    {
        $factory
            ->create('App\Form\CheeseType', $cheese, array())
            ->shouldBeCalled()
        ;

        $this->createFormFor($cheese);
    }

    /**
     * @param App\Entity\Cheese $cheese
     * @param App\Form\EditCheeseType $form
     */
    public function it_should_create_form_from_a_form_type_instance($cheese, $form, $factory)
    {
        $factory
            ->create('App\Form\EditCheeseType', $cheese, array())
            ->shouldBeCalled()
        ;

        $this->createFormFor($cheese, array(), $form);
    }
}
