<?php

namespace spec\Knp\RadBundle\DependencyInjection\Compiler;

use PHPSpec2\ObjectBehavior;

class RegisterTwigExtensionsPass extends ObjectBehavior
{
    /**
     * @param Symfony\Component\HttpKernel\Bundle\BundleInterface $bundle
     * @param Symfony\Component\DependencyInjection\ContainerBuilder $container
     * @param Knp\RadBundle\Finder\ClassFinder $classFinder
     * @param Knp\RadBundle\DependencyInjection\Compiler\TwigExtensionServiceFactory $serviceFactory
     * @param Knp\RadBundle\DependencyInjection\ReferenceFactory $referenceFactory
     * @param Symfony\Component\DependencyInjection\Definition $twigDef
     */
    function let($bundle, $container, $classFinder, $serviceFactory, $referenceFactory, $twigDef)
    {
        $this->beConstructedWith($bundle, $classFinder, $serviceFactory, $referenceFactory);

        $bundle->getPath()->willReturn('/my/project/src/App');
        $bundle->getNamespace()->willReturn('App');
    }

    function it_should_be_a_compiler_pass()
    {
        $this->shouldBeAnInstanceOf('Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface');
    }

    /**
     * @param Symfony\Component\DependencyInjection\Definition $breadDef
     * @param Symfony\Component\DependencyInjection\Definition $wineDef
     * @param Symfony\Component\DependencyInjection\Reference $breadRef
     * @param Symfony\Component\DependencyInjection\Reference $wineRef
     */
    function it_should_register_all_twig_extensions_found_in_the_bundle($bundle, $container, $classFinder, $serviceFactory, $referenceFactory, $twigDef, $breadDef, $wineDef, $breadRef, $wineRef)
    {
        $container->hasDefinition('twig')->willReturn(true);
        $container->getDefinition('twig')->willReturn($twigDef);

        $classFinder->findClassesMatching('/my/project/src/App/Twig', 'App\Twig', 'Extension$')->willReturn(array(
            'App\Twig\BreadExtension',
            'App\Twig\WineExtension'
        ));

        $serviceFactory->createDefinition('App\Twig\BreadExtension')->shouldBeCalled()->willReturn($breadDef);
        $container->setDefinition('app.twig.bread_extension', $breadDef)->shouldBeCalled();
        $referenceFactory->createReference('app.twig.bread_extension')->shouldBeCalled()->willReturn($breadRef);
        $twigDef->addMethodCall('addExtension', array($breadRef->getWrappedSubject()))->shouldBeCalled();

        $serviceFactory->createDefinition('App\Twig\WineExtension')->shouldBeCalled()->willReturn($wineDef);
        $container->setDefinition('app.twig.wine_extension', $wineDef)->shouldBeCalled();
        $referenceFactory->createReference('app.twig.wine_extension')->shouldBeCalled()->willReturn($wineRef);
        $twigDef->addMethodCall('addExtension', array($wineRef->getWrappedSubject()))->shouldBeCalled();

        $this->process($container);
    }

    function it_should_abort_processing_when_twig_is_not_defined($container, $classFinder)
    {
        $container->hasDefinition('twig')->willReturn(false);
        $container->getDefinition('twig')->shouldNotBeCalled();
        $classFinder->findClassesMatching(ANY_ARGUMENTS)->shouldNotBeCalled();

        $this->process($container);
    }

    /**
     * @param Symfony\Component\DependencyInjection\Definition $wineDef
     * @param Symfony\Component\DependencyInjection\Reference $wineRef
     */
    function it_should_underscore_camelcased_names($classFinder, $serviceFactory, $referenceFactory, $container, $twigDef, $wineDef, $wineRef)
    {
        $container->hasDefinition('twig')->willReturn(true);
        $container->getDefinition('twig')->willReturn($twigDef);

        $classFinder->findClassesMatching('/my/project/src/App/Twig', 'App\Twig', 'Extension$')->willReturn(array(
            'App\Twig\WineBourgogneExtension'
        ));

        $serviceFactory->createDefinition('App\Twig\WineBourgogneExtension')->shouldBeCalled()->willReturn($wineDef);
        $container->setDefinition('app.twig.wine_bourgogne_extension', $wineDef)->shouldBeCalled();
        $referenceFactory->createReference('app.twig.wine_bourgogne_extension')->shouldBeCalled()->willReturn($wineRef);
        $twigDef->addMethodCall('addExtension', array($wineRef->getWrappedSubject()))->shouldBeCalled();

        $this->process($container);
    }

    /**
     * @param Symfony\Component\DependencyInjection\Definition $wineDef
     * @param Symfony\Component\DependencyInjection\Reference $wineRef
     */
    function it_should_replace_namespace_separatores_by_dots_in_names($classFinder, $serviceFactory, $referenceFactory, $container, $twigDef, $wineDef, $wineRef)
    {
        $container->hasDefinition('twig')->willReturn(true);
        $container->getDefinition('twig')->willReturn($twigDef);

        $classFinder->findClassesMatching('/my/project/src/App/Twig', 'App\Twig', 'Extension$')->willReturn(array(
            'App\Twig\Wine\BourgogneExtension'
        ));

        $serviceFactory->createDefinition('App\Twig\Wine\BourgogneExtension')->shouldBeCalled()->willReturn($wineDef);
        $container->setDefinition('app.twig.wine.bourgogne_extension', $wineDef)->shouldBeCalled();
        $referenceFactory->createReference('app.twig.wine.bourgogne_extension')->shouldBeCalled()->willReturn($wineRef);
        $twigDef->addMethodCall('addExtension', array($wineRef->getWrappedSubject()))->shouldBeCalled();

        $this->process($container);
    }
}
