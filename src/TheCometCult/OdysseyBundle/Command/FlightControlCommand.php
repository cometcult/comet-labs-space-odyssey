<?php

namespace TheCometCult\OdysseyBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use TheCometCult\OdysseyBundle\Document\Mission;

class FlightControlCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('thecometcult:flight-control')
            ->setDescription('Create crews, start missions, finish missions');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Waiting for volunteers ...');
        $isLive = true;
        $startMissionCommand = $this->getApplication()->find('thecometcult:start-mission');
        $chechMissionsStatusCommand = $this->getApplication()->find('thecometcult:check-missions-status');
        while ($isLive) {
            $startMissionCommand->run($input, $output);
            $chechMissionsStatusCommand->run($input, $output);
            sleep(1);
        }
    }
}
