<?php

namespace Context;

use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Behat\MinkExtension\Context\MinkContext;

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

class FeatureContext extends BehatContext //MinkContext if you want to test web
                  implements KernelAwareInterface
{
    private $kernel;
    private $parameters;

    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Sets HttpKernel instance.
     * This method will be automatically called by Symfony2Extension ContextInitializer.
     *
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @Given /^the following products:$/
     */
    public function theFollowingProducts(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Given /^I am on the homepage$/
     */
    public function iAmOnTheHomepage()
    {
        throw new PendingException();
    }

    /**
     * @Then /^I should see cheeses Camembert, Ossau-Iraty and Munster$/
     */
    public function iShouldSeeCheesesCamembertOssauIratyAndMunster()
    {
        throw new PendingException();
    }

    /**
     * @When /^I follow the "([^"]*)" link from the menu$/
     */
    public function iFollowTheLinkFromTheMenu($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then /^I should see cheeses Maroilles and Munster$/
     */
    public function iShouldSeeCheesesMaroillesAndMunster()
    {
        throw new PendingException();
    }

    /**
     * @Then /^I should see cheeses Ossau-Iraty and Roquefort$/
     */
    public function iShouldSeeCheesesOssauIratyAndRoquefort()
    {
        throw new PendingException();
    }
}
