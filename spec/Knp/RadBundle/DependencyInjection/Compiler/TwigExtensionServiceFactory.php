<?php

namespace spec\Knp\RadBundle\DependencyInjection\Compiler;

use PHPSpec2\ObjectBehavior;

class TwigExtensionServiceFactory extends ObjectBehavior
{
    public function it_should_create_twig_extension_definition_for_the_given_class_name()
    {
        $definition = $this->createDefinition('App\Twig\BreadExtension');

        $definition->shouldBeAnInstanceOf('Symfony\Component\DependencyInjection\Definition');
        $definition->getClass()->shouldReturn('App\Twig\BreadExtension');
        $definition->isPublic()->shouldReturn(false);
    }
}
