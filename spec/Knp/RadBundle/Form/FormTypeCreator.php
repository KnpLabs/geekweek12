<?php

namespace spec\Knp\RadBundle\Form;

use PHPSpec2\ObjectBehavior;

class FormTypeCreator extends ObjectBehavior
{
    /**
     * @param Knp\RadBundle\Form\ClassMetadataFetcher $fetcher
     */
    function let($fetcher)
    {
        $this->beConstructedWith($fetcher);
    }

    function it_should_implement_form_creator_interface()
    {
        $this->shouldBeAnInstanceOf('Knp\RadBundle\Form\FormCreatorInterface');
    }

    /**
     * @param stdClass $object
     */
    function it_should_return_null_if_there_is_no_form_type($object, $fetcher)
    {
        $fetcher->getClass($object)->willReturn('App\Entity\Potato');
        $fetcher->classExists('App\Form\PotatoType')->willReturn(false);
        $fetcher->getParentClass($object)->willReturn(null);

        $this->create($object)->shouldReturn(null);
    }

    /**
     * @param stdClass $object
     * @param stdClass $formType
     */
    function it_should_return_form_type_if_there_is_one($object, $fetcher, $formType)
    {
        $fetcher->getClass($object)->willReturn('App\Entity\Cheese');
        $fetcher->classExists('App\Form\CheeseType')->willReturn(true);
        $fetcher->newInstance(
            'App\Form\CheeseType', array($object->getWrappedSubject(), array())
        )->shouldBeCalled()->willReturn($formType);

        $this->create($object)->shouldReturn($formType);
    }

    /**
     * @param stdClass $object
     * @param stdClass $formType
     */
    function it_should_return_parent_form_type_if_no_current_found($object, $fetcher, $formType)
    {
        $fetcher->getClass($object)->willReturn('App\Entity\Roquefort');
        $fetcher->classExists('App\Form\RoquefortType')->willReturn(false);
        $fetcher->getParentClass($object)->willReturn('App\Entity\Cheese');
        $fetcher->classExists('App\Form\CheeseType')->willReturn(true);

        $fetcher->newInstance(
            'App\Form\CheeseType', array($object->getWrappedSubject(), array())
        )->shouldBeCalled()->willReturn($formType);

        $this->create($object)->shouldReturn($formType);
    }
}
