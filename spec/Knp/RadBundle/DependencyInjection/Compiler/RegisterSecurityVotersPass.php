<?php

namespace spec\Knp\RadBundle\DependencyInjection\Compiler;

use PHPSpec2\ObjectBehavior;

class RegisterSecurityVotersPass extends ObjectBehavior
{
    /**
     * @param  Symfony\Component\HttpKernel\Bundle\BundleInterface $bundle
     * @param  Symfony\Component\DependencyInjection\ContainerBuilder $container
     * @param  Knp\RadBundle\Finder\ClassFinder $classFinder
     * @param  Knp\RadBundle\DependencyInjection\Definition\SecurityVoterFactory $definitionFactory
     * @param  Knp\RadBundle\DependencyInjection\ReferenceFactory $referenceFactory
     * @param  Knp\RadBundle\DependencyInjection\ServiceIdGenerator $serviceIdGenerator
     * @param  Knp\RadBundle\DependencyInjection\DefinitionManipulator $definitionManipulator
     */
    function let($bundle, $container, $classFinder, $definitionFactory, $referenceFactory, $serviceIdGenerator, $definitionManipulator)
    {
        $this->beConstructedWith($bundle, $classFinder, $definitionFactory, $referenceFactory, $serviceIdGenerator, $definitionManipulator);

        $bundle->getPath()->willReturn('/my/project/src/App');
        $bundle->getNamespace()->willReturn('App');
    }

    function it_should_be_a_compiler_pass()
    {
        $this->shouldBeAnInstanceOf('Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface');
    }

    /**
     * @param  Symfony\Component\DependencyInjection\Definition $decisionManagerDef
     * @param  Symfony\Component\DependencyInjection\Definition $cheeseVoterDef
     * @param  Symfony\Component\DependencyInjection\Definition $customerVoterDef
     * @param  Symfony\Component\DependencyInjection\Reference $cheeseVoterRef
     * @param  Symfony\Component\DependencyInjection\Reference $customerVoterRef
     */
    function it_should_register_security_voters_found_in_the_bundle($bundle, $container, $classFinder, $definitionFactory, $serviceIdGenerator, $referenceFactory, $definitionManipulator, $decisionManagerDef, $cheeseVoterDef, $customerVoterDef, $cheeseVoterRef, $customerVoterRef)
    {
        $container->hasDefinition('security.access.decision_manager')->willReturn(true);
        $container->getDefinition('security.access.decision_manager')->willReturn($decisionManagerDef);

        $classFinder->findClassesMatching('/my/project/src/App/Security', 'App\Security', 'Voter$')->willReturn(array(
            'App\Security\Voter\CheeseVoter',
            'App\Security\Voter\CustomerVoter',
        ));

        $container->hasDefinition('app.security.voter.cheese_voter')->willReturn(false)->shouldBeCalled();
        $container->hasDefinition('app.security.voter.customer_voter')->willReturn(false)->shouldBeCalled();

        $definitionFactory->createDefinition('App\Security\Voter\CheeseVoter')->willReturn($cheeseVoterDef);
        $definitionFactory->createDefinition('App\Security\Voter\CustomerVoter')->willReturn($customerVoterDef);

        $serviceIdGenerator->generateForBundleClass($bundle, 'App\Security\Voter\CheeseVoter')->shouldBeCalled()->willReturn('app.security.voter.cheese_voter');
        $serviceIdGenerator->generateForBundleClass($bundle, 'App\Security\Voter\CustomerVoter')->shouldBeCalled()->willReturn('app.security.voter.customer_voter');

        $container->setDefinition('app.security.voter.cheese_voter', $cheeseVoterDef)->shouldBeCalled();
        $container->setDefinition('app.security.voter.customer_voter', $customerVoterDef)->shouldBeCalled();

        $referenceFactory->createReference('app.security.voter.cheese_voter')->willReturn($cheeseVoterRef);
        $referenceFactory->createReference('app.security.voter.customer_voter')->willReturn($customerVoterRef);

        $definitionManipulator->appendArgumentValue($decisionManagerDef, 0, $cheeseVoterRef)->shouldBeCalled();
        $definitionManipulator->appendArgumentValue($decisionManagerDef, 0, $customerVoterRef)->shouldBeCalled();

        $this->process($container);
    }

    /**
     * @param  Symfony\Component\DependencyInjection\Definition $decisionManagerDef
     * @param  Symfony\Component\DependencyInjection\Definition $cheeseVoterDef
     * @param  Symfony\Component\DependencyInjection\Definition $customerVoterDef
     * @param  Symfony\Component\DependencyInjection\Reference $cheeseVoterRef
     * @param  Symfony\Component\DependencyInjection\Reference $customerVoterRef
     */
    function it_should_not_register_security_voters_alread_defined_as_services($bundle, $container, $classFinder, $definitionFactory, $serviceIdGenerator, $referenceFactory, $definitionManipulator, $decisionManagerDef, $cheeseVoterDef, $customerVoterDef, $cheeseVoterRef, $customerVoterRef)
    {
        $container->hasDefinition('security.access.decision_manager')->willReturn(true);
        $container->getDefinition('security.access.decision_manager')->willReturn($decisionManagerDef);

        $classFinder->findClassesMatching('/my/project/src/App/Security', 'App\Security', 'Voter$')->willReturn(array(
            'App\Security\Voter\CheeseVoter',
            'App\Security\Voter\CustomerVoter',
        ));

        $container->hasDefinition('app.security.voter.cheese_voter')->willReturn(false)->shouldBeCalled();
        $container->hasDefinition('app.security.voter.customer_voter')->willReturn(true)->shouldBeCalled();

        $definitionFactory->createDefinition('App\Security\Voter\CheeseVoter')->willReturn($cheeseVoterDef);
        $definitionFactory->createDefinition('App\Security\Voter\CustomerVoter')->shouldNotBeCalled();

        $serviceIdGenerator->generateForBundleClass($bundle, 'App\Security\Voter\CheeseVoter')->shouldBeCalled()->willReturn('app.security.voter.cheese_voter');
        $serviceIdGenerator->generateForBundleClass($bundle, 'App\Security\Voter\CustomerVoter')->shouldBeCalled()->willReturn('app.security.voter.customer_voter');

        $container->setDefinition('app.security.voter.cheese_voter', $cheeseVoterDef)->shouldBeCalled();
        $container->setDefinition('app.security.voter.customer_voter', $customerVoterDef)->shouldNotBeCalled();

        $referenceFactory->createReference('app.security.voter.cheese_voter')->willReturn($cheeseVoterRef);
        $referenceFactory->createReference('app.security.voter.customer_voter')->shouldNotBeCalled();

        $definitionManipulator->appendArgumentValue($decisionManagerDef, 0, $cheeseVoterRef)->shouldBeCalled();
        $definitionManipulator->appendArgumentValue($decisionManagerDef, 0, $customerVoterRef)->shouldNotBeCalled();

        $this->process($container);
    }

    function it_should_abort_processing_when_decision_manager_is_not_defined($container, $classFinder)
    {
        $container->hasDefinition('security.access.decision_manager')->willReturn(false);
        $container->getDefinition('security.access.decision_manager')->shouldNotBeCalled();
        $classFinder->findClassesMatching(ANY_ARGUMENTS)->shouldNotBeCalled();

        $this->process($container);
    }
}
