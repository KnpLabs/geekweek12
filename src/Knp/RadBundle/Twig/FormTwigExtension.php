<?php

namespace Knp\RadBundle\Twig;

class FormTwigExtension extends \Twig_Extension
{

    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function getFunctions()
    {
        return array(
            'bootstrap_form' => new \Twig_Function_Method($this, 'getFormRender', array('is_safe' => array('html'))),
        );
    }

    public function getFormRender($form, $path, $options = array())
    {
        $options = array_merge(
            array(
                'bootstrap'     => 'Default',
                'method'        => 'POST',
                'parameters'    => array(),
                ), 
            $options)
        ;

        switch($options){
            case 'POST':
            case 'GET':
                break;
            default:
                $options['_method'] = $options['method'];
                $options['method'] = 'POST';
                break;
        }

        return $this
            ->container
            ->get('templating')
            ->render(
                'KnpRadBundle:Twig:Form/' . $options['bootstrap'] . '/form.html.twig',
                array(
                    'form'      => $form,
                    'path'      => $path,
                    'options'   => $options,
                )
            )
        ;


    }

    public function getName()
    {
        return 'knp_rad.twig.form';
    }

}