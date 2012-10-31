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

    function it_should_implement_interface()
    {
        $this->shouldBeAnInstanceOf('Knp\RadBundle\Form\FormCreatorInterface');
    }

    /**
     * @param Knp\Entity\Cheese $cheese
     */
    function it_should_not_create_a_form_if_form_type_cannot_be_found($cheese, $fetcher)
    {
        $fetcher
            ->classExists('Knp\Form\CheeseType')
            ->willReturn(false)
        ;

        $this->create($cheese)->shouldBeNull();
    }
}
