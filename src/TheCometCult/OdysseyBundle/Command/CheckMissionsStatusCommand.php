<?php

namespace TheCometCult\OdysseyBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use TheCometCult\OdysseyBundle\Document\Mission;

class CheckMissionsStatusCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('thecometcult:check-missions-status')
            ->setDescription('Check missions status and finish if needed');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();
        $missions = $dm->createQueryBuilder('TheCometCultOdysseyBundle:Mission')
            ->field('eta')->lte(new \DateTime())
            ->field('status')->equals(Mission::STATUS_MISSION_ONGOING)
            ->getQuery()
            ->execute();

        $missionManager = $this->getContainer()->get('the_comet_cult_odyssey.mission_manager');
        foreach ($missions as $mission) {
            $updatedMission = $missionManager->updateMissionStatus($mission);
            $output->writeln(sprintf('Mission status is now: %s', $updatedMission->getStatus()));
        }
    }
}
