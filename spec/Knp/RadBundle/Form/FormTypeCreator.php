<?php

namespace spec\Knp\RadBundle\Form;

use PHPSpec2\ObjectBehavior;

class FormTypeCreator extends ObjectBehavior
{
    /**
     * @param Knp\RadBundle\Reflection\ClassMetadataFetcher $fetcher
     * @param Symfony\Component\Form\FormFactoryInterface $factory
     */
    function let($fetcher, $factory)
    {
        $this->beConstructedWith($fetcher, $factory);
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
     * @param Symfony\Component\Form\Form $form
     */
    function it_should_return_form_type_if_there_is_one($object, $fetcher, $factory, $formType, $form)
    {
        $fetcher->getClass($object)->willReturn('App\Entity\Cheese');
        $fetcher->classExists('App\Form\CheeseType')->willReturn(true);
        $fetcher->newInstance('App\Form\CheeseType')->shouldBeCalled()->willReturn($formType);
        $factory->create($formType, $object, array())->shouldBeCalled()->willReturn($form);

        $this->create($object)->shouldReturn($form);
    }

    /**
     * @param stdClass $object
     * @param stdClass $formType
     * @param Symfony\Component\Form\Form $form
     */
    function it_should_return_form_type_with_purpose_if_there_is_one($object, $fetcher, $factory, $formType, $form)
    {
        $fetcher->getClass($object)->willReturn('App\Entity\Cheese');
        $fetcher->classExists('App\Form\EditCheeseType')->willReturn(true);
        $fetcher->newInstance('App\Form\EditCheeseType')->shouldBeCalled()->willReturn($formType);
        $factory->create($formType, $object, array())->shouldBeCalled()->willReturn($form);

        $this->create($object, 'edit')->shouldReturn($form);
    }

    /**
     * @param stdClass $object
     * @param stdClass $formType
     * @param Symfony\Component\Form\Form $form
     */
    function it_should_fallback_on_default_form_type_if_given_purpose_has_no_associated_form_type($object, $fetcher, $factory, $formType, $form)
    {
        $fetcher->getClass($object)->willReturn('App\Entity\Cheese');
        $fetcher->classExists('App\Form\EditCheeseType')->willReturn(false);
        $fetcher->classExists('App\Form\CheeseType')->willReturn(true);
        $fetcher->newInstance('App\Form\CheeseType')->shouldBeCalled()->willReturn($formType);
        $factory->create($formType, $object, array())->shouldBeCalled()->willReturn($form);

        $this->create($object, 'edit')->shouldReturn($form);
    }

    /**
     * @param stdClass $object
     * @param stdClass $formType
     * @param Symfony\Component\Form\Form $form
     */
    function it_should_return_null_if_given_purpose_has_no_associated_form_type_and_no_default_form_type($object, $fetcher, $factory, $formType, $form)
    {
        $fetcher->getClass($object)->willReturn('App\Entity\Cheese');
        $fetcher->getParentClass('App\Entity\Cheese')->willReturn(null);
        $fetcher->classExists('App\Form\CheeseType')->willReturn(false);
        $fetcher->classExists('App\Form\EditCheeseType')->willReturn(false);

        $this->create($object, 'edit')->shouldReturn(null);
    }

    /**
     * @param stdClass $object
     * @param stdClass $formType
     * @param Symfony\Component\Form\Form $form
     */
    function it_should_return_parent_form_type_if_no_current_found($object, $fetcher, $factory, $formType, $form)
    {
        $fetcher->getClass($object)->willReturn('App\Entity\Roquefort');
        $fetcher->classExists('App\Form\RoquefortType')->willReturn(false);
        $fetcher->getParentClass($object)->willReturn('App\Entity\Cheese');
        $fetcher->classExists('App\Form\CheeseType')->willReturn(true);
        $fetcher->newInstance('App\Form\CheeseType')->shouldBeCalled()->willReturn($formType);
        $factory->create($formType, $object, array())->shouldBeCalled()->willReturn($form);

        $this->create($object)->shouldReturn($form);
    }
}
