<?php

namespace spec\Knp\RadBundle\Form;

use PHPSpec2\ObjectBehavior;

class DefaultFormCreator extends ObjectBehavior
{
    /**
     * @param Symfony\Component\Form\FormFactoryInterface $factory
     * @param Symfony\Component\Form\FormBuilderInterface $factory
     */
    public function let($builder)
    {
        $this->beConstructedWith($factory, $builder);
    }

    /**
     * @param ReflectionClass $class
     */
 //   function it_should_build_form_from_an_object_properties($class, $builder)
 //   {
 //       $class
 //           ->getMethods()
 //           ->willReturn(array(
 //               'getName', 'setName',
 //               'isAdmin', 'setAdmin',
 //               'getId',
 //           ))
 //       ;
 //
 //       $class
 //           ->hasMethod('setName')
 //           ->willReturn(true)
 //       ;
 //
 //       $class
 //           ->hasMethod('setAdmin')
 //           ->willReturn(true)
 //       ;
 //
 //       $class
 //           ->hasMethod('setId')
 //           ->willReturn(false)
 //       ;
 //
 //       $builder
 //           ->add('name')
 //           ->shouldBeCalled()
 //       ;
 //
 //       $builder
 //           ->add('admin')
 //           ->shouldBeCalled()
 //       ;
 //
 //       $this->buildFormForObject($class);
 //   }
}
