<?php

namespace spec\Knp\RadBundle\Form;

use PHPSpec2\ObjectBehavior;
use PHPSpec2\Exception\Example\PendingException;

class FormManager extends ObjectBehavior
{
    /**
     * @param Knp\RadBundle\Form\FormCreatorInterface $creator1
     * @param Knp\RadBundle\Form\FormCreatorInterface $creator2
     * @param Knp\RadBundle\Form\FormCreatorInterface $creator3
     */
    public function let($creator1, $creator2, $creator3)
    {
        $this->registerCreator($creator1);
        $this->registerCreator($creator2);
        $this->registerCreator($creator3);
    }

    function it_should_be_able_to_register_creators($creator1, $creator2)
    {
        $this->getCreators()->shouldHaveCount(3);
    }

    /**
     * @param stdClass $object
     */
    function it_should_try_to_create_form_with_registered_creators($object, $creator1, $creator2)
    {
        $creator1->create($object, 'edit', array())->willReturn(null)->shouldBeCalled();
        $creator2->create($object, 'edit', array())->willReturn(true)->shouldBeCalled();

        $this->createObjectForm($object, 'edit');
    }

    /**
     * @param stdClass $object
     */
    function its_createObjectForm_should_throw_exception_if_no_creator_fits($object, $creator1, $creator2, $creator3)
    {
        $creator1->create($object, 'edit', array())->willReturn(null)->shouldBeCalled();
        $creator2->create($object, 'edit', array())->willReturn(null)->shouldBeCalled();
        $creator3->create($object, 'edit', array())->willReturn(null)->shouldBeCalled();

        $this->shouldThrow()->duringCreateObjectForm($object, 'edit');
    }

    /**
     * @param stdClass $object
     */
    function it_should_return_first_non_null_result_from_creator($object, $creator1, $creator2, $creator3)
    {
        $creator1->create($object, 'edit', array())->willReturn(null)->shouldBeCalled();
        $creator2->create($object, 'edit', array())->willReturn(true)->shouldBeCalled();
        $creator3->create($object, 'edit', array())->shouldNotBeCalled();

        $this->createObjectForm($object, 'edit');
    }
}
