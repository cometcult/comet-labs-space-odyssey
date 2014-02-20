<?php

namespace TheCometCult\OdysseyBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use TheCometCult\OdysseyBundle\Document\Mission;

class StartMissionCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('thecometcult:start-mission')
            ->setDescription('Start missions that reached departure time');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();

        $missions = $dm->createQueryBuilder('TheCometCultOdysseyBundle:Mission')
            ->field('departedAt')->lte(new \DateTime())
            ->field('status')->equals(Mission::STATUS_MISSION_COUNTDOWN)
            ->getQuery()
            ->execute();

        $missionManager = $this->getContainer()->get('the_comet_cult_odyssey.mission_manager');
        foreach ($missions as $mission) {
            $missionManager->startMission($mission);
            $output->writeln(sprintf(
                'mission created at: %s and departed at: %s',
                date('H:i:s', $mission->getCreatedAtTimestamp()),
                date('H:i:s', $mission->getDepartedAtTimestamp())
            ));
        }
    }
}
