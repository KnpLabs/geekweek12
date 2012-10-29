<?php

namespace Context;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Behat\MinkExtension\Context\MinkContext;

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException,

    Behat\Behat\Context\Step;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use App\Entity\Cheese;

require_once 'PHPUnit/Autoload.php';
require_once 'PHPUnit/Framework/Assert/Functions.php';

class FeatureContext extends MinkContext
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
     * @BeforeScenario
     */
    public function purgeDatabase()
    {
        $em = $this->getEntityManager();

        $purger = new ORMPurger($em);
        $purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);
        $purger->purge();
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
     * @Given /^the following (.*)[s]:$/
     */
    public function theFollowingEntities($entityName, TableNode $table)
    {
        $rows = $table->getRows();
        foreach ($rows as $i => $row) {
            if($i > 0){
                switch ($entityName) {
                    case 'cheese':
                            $this->generateCheese($rows[0], $row);
                        break;
                    default:
                        throw new Exception(sprintf('Entity %s unknow !', $entityName));
                        break;
                }
            }
        }
    }

    public function generateCheese($headers, $rows)
    {
        $em = $this->getEntityManager();
        $entity = new Cheese();
        foreach ($rows as $index => $value) {
            $header = $headers[$index];
            switch ($header) {
                case 'rating':
                    $rating = explode('/', $value);
                    $entity->setTotalRating($rating[0] * $rating[1]);
                    $entity->setTotalVote($rating[1]);
                    break;
                default:
                    $entity->{'set'.ucFirst($header)}($value);
                    break;
            }
        }
        $em->persist($entity);
        $em->flush();
    }

    /**
     * @Given /^I am on the homepage$/
     */
    public function iAmOnTheHomepage()
    {
        return new Step\Given(sprintf('I am on "%s"', '/'));
    }

    /**
     * @Then /^I should see cheese[s] (.*)$/
     */
    public function iShouldSeeCheeses($cheeses)
    {
        $cheeses = $this->listToArray($cheeses);

        $rows = $this->getSession()->getPage()->findAll('css', 'table tbody tr');
    
        $values = array();
        foreach ($rows as $row) {
            $cols = $row->findAll('css', 'td');
            $values[]  = $cols[0]->getText();
        }

        sort($cheeses);
        sort($values);

        assertEquals($cheeses, $values, sprintf(
            'Expecting to see cheeses %s, actually saw %s',
            join(', ', $cheeses),
            join(', ', $values)
        ));

    }

    /**
     * @When /^I follow the "([^"]*)" link from the menu$/
     */
    public function iFollowTheLinkFromTheMenu($link)
    {
        return new Step\Given(sprintf('I follow "%s"', $link));
    }

    private function listToArray($list)
    {
        $list  = str_replace(' and ', ', ', $list);
        $parts = explode(', ', $list);

        return array_map('trim', $parts);
    }

    private function getEntityManager()
    {
        return $this->getDoctrine()->getEntityManager();
    }

    private function getDoctrine()
    {
        return $this->getContainer()->get('doctrine');
    }

    private function getContainer()
    {
        return $this->kernel->getContainer();
    }
}
