<?php

namespace spec\Knp\RadBundle\Routing\Loader;

use PHPSpec2\ObjectBehavior;

class ConventionalLoader extends ObjectBehavior
{
    /**
     * @param Symfony\Component\Config\FileLocatorInterface $locator
     * @param Knp\RadBundle\Routing\Loader\YamlParser       $yaml
     */
    function let($locator, $yaml)
    {
        $this->beConstructedWith($locator, $yaml);

        $locator->locate('routing.yml')->willReturn('yaml file');
    }

    function it_should_support_conventional_resources()
    {
        $this->supports('', 'conventional')->shouldReturn(true);
    }

    function it_should_not_support_other_resources()
    {
        $this->supports('')->shouldNotReturn(true);
    }

    function it_should_load_simple_collection_by_conventions($yaml)
    {
        $yaml->parse('yaml file')->willReturn(array(
            'App:Cheeses' => null
        ));

        $routes = $this->load('routing.yml');

        $index = $routes->get('app_cheeses_index');
        $index->getPattern()->shouldReturn('/cheeses/');
        $index->getDefaults()->shouldReturn(array('_controller' => 'App:Cheeses:index'));
        $index->getRequirements()->shouldReturn(array('_method' => 'GET'));

        $new = $routes->get('app_cheeses_new');
        $new->getPattern()->shouldReturn('/cheeses/new');
        $new->getDefaults()->shouldReturn(array('_controller' => 'App:Cheeses:new'));
        $new->getRequirements()->shouldReturn(array('_method' => 'GET'));

        $new = $routes->get('app_cheeses_create');
        $new->getPattern()->shouldReturn('/cheeses/');
        $new->getDefaults()->shouldReturn(array('_controller' => 'App:Cheeses:new'));
        $new->getRequirements()->shouldReturn(array('_method' => 'POST'));

        $show = $routes->get('app_cheeses_show');
        $show->getPattern()->shouldReturn('/cheeses/{id}');
        $show->getDefaults()->shouldReturn(array('_controller' => 'App:Cheeses:show'));
        $show->getRequirements()->shouldReturn(array('_method' => 'GET', 'id' => '\\d+'));

        $edit = $routes->get('app_cheeses_edit');
        $edit->getPattern()->shouldReturn('/cheeses/{id}/edit');
        $edit->getDefaults()->shouldReturn(array('_controller' => 'App:Cheeses:edit'));
        $edit->getRequirements()->shouldReturn(array('_method' => 'GET', 'id' => '\\d+'));

        $edit = $routes->get('app_cheeses_update');
        $edit->getPattern()->shouldReturn('/cheeses/{id}');
        $edit->getDefaults()->shouldReturn(array('_controller' => 'App:Cheeses:edit'));
        $edit->getRequirements()->shouldReturn(array('_method' => 'PUT', 'id' => '\\d+'));

        $delete = $routes->get('app_cheeses_delete');
        $delete->getPattern()->shouldReturn('/cheeses/{id}');
        $delete->getDefaults()->shouldReturn(array('_controller' => 'App:Cheeses:delete'));
        $delete->getRequirements()->shouldReturn(array('_method' => 'DELETE', 'id' => '\\d+'));

        $routes->shouldHaveCount(7);
    }

    function it_should_load_collections_with_custom_prefix($yaml)
    {
        $yaml->parse('yaml file')->willReturn(array(
            'App:Cheeses' => '/custom/prefix'
        ));

        $routes = $this->load('routing.yml');

        $index = $routes->get('app_cheeses_index');
        $index->getPattern()->shouldReturn('/custom/prefix/');
        $index->getDefaults()->shouldReturn(array('_controller' => 'App:Cheeses:index'));
        $index->getRequirements()->shouldReturn(array('_method' => 'GET'));

        $new = $routes->get('app_cheeses_new');
        $new->getPattern()->shouldReturn('/custom/prefix/new');
        $new->getDefaults()->shouldReturn(array('_controller' => 'App:Cheeses:new'));
        $new->getRequirements()->shouldReturn(array('_method' => 'GET'));

        $new = $routes->get('app_cheeses_create');
        $new->getPattern()->shouldReturn('/custom/prefix/');
        $new->getDefaults()->shouldReturn(array('_controller' => 'App:Cheeses:new'));
        $new->getRequirements()->shouldReturn(array('_method' => 'POST'));

        $show = $routes->get('app_cheeses_show');
        $show->getPattern()->shouldReturn('/custom/prefix/{id}');
        $show->getDefaults()->shouldReturn(array('_controller' => 'App:Cheeses:show'));
        $show->getRequirements()->shouldReturn(array('_method' => 'GET', 'id' => '\\d+'));

        $edit = $routes->get('app_cheeses_edit');
        $edit->getPattern()->shouldReturn('/custom/prefix/{id}/edit');
        $edit->getDefaults()->shouldReturn(array('_controller' => 'App:Cheeses:edit'));
        $edit->getRequirements()->shouldReturn(array('_method' => 'GET', 'id' => '\\d+'));

        $edit = $routes->get('app_cheeses_update');
        $edit->getPattern()->shouldReturn('/custom/prefix/{id}');
        $edit->getDefaults()->shouldReturn(array('_controller' => 'App:Cheeses:edit'));
        $edit->getRequirements()->shouldReturn(array('_method' => 'PUT', 'id' => '\\d+'));

        $delete = $routes->get('app_cheeses_delete');
        $delete->getPattern()->shouldReturn('/custom/prefix/{id}');
        $delete->getDefaults()->shouldReturn(array('_controller' => 'App:Cheeses:delete'));
        $delete->getRequirements()->shouldReturn(array('_method' => 'DELETE', 'id' => '\\d+'));

        $routes->shouldHaveCount(7);
    }
}
