<?php

namespace Knp\RadBundle\Twig;

class ButtonTwigExtension extends \Twig_Extension
{

    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            'bootstrap_button' => new \Twig_Function_Method($this, 'getButtonRender', array('is_safe' => array('html'))),
        );
    }

    public function getButtonRender($content, $options = array())
    {
        $options = array_merge(
            array(
                'bootstrap'     => 'Default',
                'tag'           => 'a',
                'parameters'    => array(),
                'class'         => ''
                ), 
            $options)
        ;

        return $this
            ->container
            ->get('templating')
            ->render(
                'KnpRadBundle:Twig:Button/' . $options['bootstrap'] . '/button.html.twig',
                array(
                    'content' => $content,
                    'options' => $options,
                )
            )
        ;


    }

    public function getName()
    {
        return 'knp_rad.twig.button';
    }

}