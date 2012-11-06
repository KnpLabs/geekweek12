<?php

namespace spec\Knp\RadBundle\EventListener;

use PHPSpec2\ObjectBehavior;

class ViewListener extends ObjectBehavior
{
    /**
     * @param Symfony\Component\HttpFoundation\Request $request
     * @param Symfony\Component\HttpFoundation\Response $response
     * @param Symfony\Bundle\FrameworkBundle\Templating\EngineInterface $engine
     * @param Symfony\Bundle\FrameworkBundle\Controller\ControllerNameParser $cnp
     * @param Knp\RadBundle\HttpFoundation\RequestManipulator $reqManip
     * @param Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent $event
     */
    function let($request, $response, $engine, $cnp, $reqManip, $event)
    {
        $this->beConstructedWith($engine, $cnp, 'twig', $reqManip);

        $event->getRequest()->willReturn($request);
        $event->getControllerResult()->willReturn(array('foo' => 'bar'));
    }

    function it_should_create_a_view_response_when_controller_did_not_return_response($request, $response, $reqManip, $engine, $event)
    {
        $reqManip->hasAttribute($request, '_controller')->willReturn(true);
        $reqManip->getAttribute($request, '_controller')->willReturn('App\Controller\CheeseController::eatAction');

        $request->getRequestFormat()->willReturn('html');

        $engine->renderResponse('App:Cheese:eat.html.twig', array('foo' => 'bar'))->willReturn($response);

        $event->setResponse($response)->shouldBeCalled();

        $this->onKernelView($event);
    }

    function it_should_resolve_controller_when_not_yet_resolved($request, $response, $reqManip, $engine, $event, $cnp)
    {
        $reqManip->hasAttribute($request, '_controller')->willReturn(true);
        $reqManip->getAttribute($request, '_controller')->willReturn('App:Cheese:eat');

        $cnp->parse('App:Cheese:eat')->willReturn('App\Controller\CheeseController::eatAction');

        $request->getRequestFormat()->willReturn('html');

        $engine->renderResponse('App:Cheese:eat.html.twig', array('foo' => 'bar'))->willReturn($response);

        $event->setResponse($response)->shouldBeCalled();

        $this->onKernelView($event);
    }

    function it_should_abort_when_controller_is_not_in_request_attributes($reqManip, $request, $event)
    {
        $reqManip->hasAttribute($request, '_controller')->willReturn(false);

        $event->setResponse(ANY_ARGUMENTS)->shouldNotBeCalled();

        $this->onKernelView($event);
    }
}
