<?php

namespace TheCometCult\OdysseyBundle\Features\Context;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Exception\BehaviorException;
use Behat\Symfony2Extension\Context\KernelAwareInterface;

use Symfony\Component\HttpKernel\KernelInterface;

use Mockery;

class TimeContext extends BehatContext implements KernelAwareInterface
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
     * @param mixed  $response
     */
    public function mockTimeManagerServiceResponse($method, $response)
    {
        $this->kernel->getContainer()
            ->mock('the_comet_cult_odyssey.time_manager', 'TheCometCult\OdysseyBundle\Manager\TimeManager')
            ->shouldReceive($method)
            ->once()
            ->andReturn($response);
    }
}
