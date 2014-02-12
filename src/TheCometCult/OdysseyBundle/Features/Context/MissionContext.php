<?php

namespace TheCometCult\OdysseyBundle\Features\Context;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Exception\BehaviorException;
use Behat\Behat\Exception\PendingException;

use TheCometCult\OdysseyBundle\Document\Mission;
use TheCometCult\OdysseyBundle\Document\Crew;

class MissionContext extends BehatContext
{
    /**
     * @Given /^misson launch time should start countdown$/
     */
    public function missonLaunchTimeShouldStartCountdown()
    {
        $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();
        $missionCountingDown = $dm->createQueryBuilder('TheCometCultOdysseyBundle:Mission')
            ->field('status')->equals(Mission::STATUS_MISSION_COUNTDOWN)
            ->getQuery()
            ->count();

        if ($missionCountingDown < 1) {
            throw new BehaviorException('There are no missions counting down');
        }
    }

    /**
     * @Given /^crew\'s next misson start time is reached$/
     */
    public function crewsNextMissonStartTimeIsReached()
    {
        $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();
        $readyToFlyCrew = $dm->createQueryBuilder('TheCometCultOdysseyBundle:Crew')
            ->field('status')->equals(Crew::STATUS_READY_TO_FLY)
            ->getQuery()
            ->getSingleResult();

        $mission = new Mission();
        $mission->setDepartedAt(strtotime('-1 day'));
        $mission->setCrew($readyToFlyCrew);

        $dm->persist($mission);
        $dm->flush();
    }

    /**
     * @Then /^the mission is started$/
     */
    public function theMissionIsStarted()
    {
        $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();
        $missionsCount = $dm->createQueryBuilder('TheCometCultOdysseyBundle:Mission')
            ->field('status')->equals(Mission::STATUS_MISSION_ONGOING)
            ->getQuery()
            ->count();

        if ($missionsCount < 1) {
            throw new BehaviorException('There are no ongoing missions');
        }
    }

    protected function getContainer()
    {
        return $this->getMainContext()->getContainer();
    }
}
