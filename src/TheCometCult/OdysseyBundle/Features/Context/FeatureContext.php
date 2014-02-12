<?php

namespace TheCometCult\OdysseyBundle\Features\Context;

use Behat\Symfony2Extension\Context\KernelAwareInterface;

use Symfony\Component\HttpKernel\KernelInterface;

use Doctrine\Common\DataFixtures\Purger\MongoDBPurger;
use Doctrine\Common\DataFixtures\Executor\MongoDBExecutor;

use Behat\MinkExtension\Context\RawMinkContext;

class FeatureContext extends RawMinkContext implements KernelAwareInterface
{
    /**
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * @BeforeScenario
     */
    public function setUp()
    {
        $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();
        $purger = new MongoDBPurger($dm);
        $executor = new MongoDBExecutor($dm, $purger);
        $executor->purge();
    }

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        $this->useContext('volunteer', new VolunteerContext());
        $this->useContext('crew', new CrewContext());
        $this->useContext('mission', new MissionContext());
        $this->useContext('message', new MessageContext());
    }

    /**
     * @param \Symfony\Component\HttpKernel\KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;

        $this->useContext('command', new CommandContext($kernel));
    }

    /**
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    public function getContainer()
    {
        return $this->kernel->getContainer();
    }
}
