<?php

namespace TheCometCult\OdysseyBundle\Features\Context;

use Behat\Behat\Context\BehatContext;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Bundle\FrameworkBundle\Console\Application;

use TheCometCult\OdysseyBundle\Command\StartMissionCommand;

class CommandContext extends BehatContext
{
    protected $application;

    public function __construct(KernelInterface $kernel)
    {
        $this->application = new Application($kernel);
        $this->application->add(new StartMissionCommand());
    }

    /**
     * @When /^the mission starting routine is run$/
     */
    public function theMissionStartingRoutineIsRun()
    {
        $command = $this->application->find('thecometcult:start-mission');
        $this->tester = new CommandTester($command);
        $this->tester->execute(array('command' => $command->getName()));
    }

}
