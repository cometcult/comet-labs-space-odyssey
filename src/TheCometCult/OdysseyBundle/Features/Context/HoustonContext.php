<?php

namespace TheCometCult\OdysseyBundle\Features\Context;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Exception\BehaviorException;
use Behat\Symfony2Extension\Context\KernelAwareInterface;

use Symfony\Component\HttpKernel\KernelInterface;

use Mockery;

class HoustonContext extends BehatContext implements KernelAwareInterface
{
    /**
     * @var KernelInterface $kernel
     */
    private $kernel = null;

    /**
     * @param KernelInterface $kernel
     *
     * @return null
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @param string $method
     * @param mixed $response
     */
    public function mockHoustonServiceResponse($method, $response)
    {
        $this->kernel->getContainer()
            ->mock('the_comet_cult_odyssey.houston', 'TheCometCult\OdysseyBundle\Mission\Checker\FoursquareChecker')
            ->shouldReceive($method)
            ->withAnyArgs()
            ->once()
            ->andReturn($response);
    }
}
