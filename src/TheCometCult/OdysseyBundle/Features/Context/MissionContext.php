<?php

namespace TheCometCult\OdysseyBundle\Features\Context;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Exception\BehaviorException;
use Behat\Behat\Exception\PendingException;

use TheCometCult\OdysseyBundle\Document\Mission;
use TheCometCult\OdysseyBundle\Document\Crew;

class MissionContext extends BehatContext
{
    protected $missionEta;

    protected $houstonStatusReport;

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
        $readyToFlyCrew = $this->findReadyToFlyCrew();

        $mission = new Mission();
        $mission->setDepartedAt(strtotime('-1 day'));
        $mission->setCrew($readyToFlyCrew);

        $dm->persist($mission);
        $dm->flush();
    }

     /**
     * @Given /^average mission ETA is (\d+) days$/
     */
    public function averageMissionEtaIsDays($eta)
    {
        $this->missionEta = $eta;
    }

    /**
     * @Given /^the mission has started (\d+) days ago$/
     */
    public function theMissionHasStartedDaysAgo($departedDaysAgo)
    {
        $timeManager = $this->getContainer()->get('the_comet_cult_odyssey.time_manager');
        $departureDelay = $timeManager->getDepartureDelay() / 24 * 60;
        $missionStartedAt = strtotime('-' . $departedDaysAgo + $departureDelay . ' day');
        $missionDepartedAt = strtotime('-' . $departedDaysAgo . ' day');
        $this->getTimeContext()->mockTimeManagerServiceResponse('getTime', $missionStartedAt);
        $this->getTimeContext()->mockTimeManagerServiceResponse('generateDepartureTime', $missionDepartedAt);

        $missionEta = $departedDaysAgo - $this->missionEta != 0 ?
            strtotime($departedDaysAgo - $this->missionEta . ' day') : strtotime('now');

        $departure = new \DateTime(date('Y-m-d H:i:s', $missionDepartedAt));
        $etaTimestamp = $departure->format('Y-m-d H:i:s') .' +' . $this->missionEta . ' days';
        $eta = new \DateTime(date('Y-m-d H:i:s', strtotime($etaTimestamp)));

        $this->getTimeContext()->mockTimeManagerServiceResponse('generateMissionEta', $missionEta);

        $readyToFlyCrew = $this->findReadyToFlyCrew();
        $missionManager = $this->getContainer()->get('the_comet_cult_odyssey.mission_manager');
        $mission = $missionManager->createMission($readyToFlyCrew);
        $missionManager->startMission($mission);

        $this->isMissionStarted();
    }

    /**
     * @Then /^the mission should be finished$/
     */
    public function theMissionShouldBeFinished()
    {
        $this->isMissionFinished();
    }

    /**
     * @When /^daily status report states "([^"]*)"$/
     */
    public function dailyStatusReportStates($status)
    {
        if ($status == 'unknown') {
            $status = null;
        }
        $this->getHoustonContext()->mockHoustonServiceResponse('getMissionStatus', $status);
    }

    /**
     * @Then /^the mission should be started$/
     * @Then /^the mission should not be finished$/
     */
    public function theMissionShouldBeStarted()
    {
        $this->isMissionStarted();
    }

    protected function findReadyToFlyCrew()
    {
        $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();

        return $dm->createQueryBuilder('TheCometCultOdysseyBundle:Crew')
            ->field('status')->equals(Crew::STATUS_READY_TO_FLY)
            ->getQuery()
            ->getSingleResult();
    }

    protected function findOngoingMission()
    {
        $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();

        return $dm->createQueryBuilder('TheCometCultOdysseyBundle:Mission')
            ->field('status')->equals(Mission::STATUS_MISSION_ONGOING)
            ->getQuery()
            ->getSingleResult();
    }

    protected function isMissionStarted()
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

    protected function isMissionFinished()
    {
        $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();
        $missionsCount = $dm->createQueryBuilder('TheCometCultOdysseyBundle:Mission')
            ->field('finished')->equals(true)
            ->getQuery()
            ->count();

        if ($missionsCount < 1) {
            throw new BehaviorException('There are no ongoing missions');
        }
    }

    protected function getTimeContext()
    {
        return $this
            ->getMainContext()
            ->getSubcontext('time');
    }

    protected function getHoustonContext()
    {
        return $this
            ->getMainContext()
            ->getSubcontext('houston');
    }

    protected function getContainer()
    {
        return $this->getMainContext()->getContainer();
    }
}
