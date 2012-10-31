<?php

namespace spec\Knp\RadBundle\Form;

use PHPSpec2\ObjectBehavior;
use PHPSpec2\Exception\Example\PendingException;

class FormManager extends ObjectBehavior
{
    /**
     * @param Symfony\Component\Form\FormFactory $factory
     * @param Knp\RadBundle\Form\DefaultFormCreator $formCreator
     */
    function let($factory, $formCreator)
    {
        $this->beConstructedWith($factory, $formCreator);
    }


    /**
     * @param App\Entity\Wine $wine
     */
    function it_should_use_form_type_if_has_one($wine, $factory)
    {
        $factory
            ->create('App\Form\WineType', $wine, array())
            ->shouldBeCalled()
        ;

        $this->createFormFor($wine);
    }

    /**
     * @param App\Entity\Cheese $cheese
     */
    function it_should_build_form_if_there_is_no_form_type($cheese, $formCreator, $factory)
    {
        $formCreator
            ->setFormBuilder($factory->createBuilder('form', $cheese, array()))
            ->shouldBeCalled()
        ;

        $formCreator
            ->buildFormForObject($cheese)
            ->shouldBeCalled()
        ;

        $this->createFormFor($cheese);
    }

    /**
     * @param App\Entity\Cheese $cheese
     */
    function it_should_create_new_form_type($cheese, $factory)
    {
        $factory
            ->create('App\Form\NewCheeseType', $cheese, array())
            ->shouldBeCalled()
        ;

        $this->createFormFor($cheese, 'new');
    }

    /**
     * @param App\Entity\Cheese $cheese
     */
    function it_should_create_edit_form_type($cheese, $factory)
    {
        $factory
            ->create('App\Form\EditCheeseType', $cheese, array())
            ->shouldBeCalled()
        ;

        $this->createFormFor($cheese, 'edit');
    }
}
