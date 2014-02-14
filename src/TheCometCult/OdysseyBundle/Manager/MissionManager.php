<?php

namespace TheCometCult\OdysseyBundle\Manager;

use Doctrine\ODM\MongoDB\DocumentManager;

use TheCometCult\OdysseyBundle\Document\Mission;
use TheCometCult\OdysseyBundle\Document\Crew;
use TheCometCult\OdysseyBundle\Manager\TimeManagerInterface;
use TheCometCult\OdysseyBundle\Mission\Checker\HoustonInterface;
use TheCometCult\OdysseyBundle\Logger\MissionLoggerInterface;

class MissionManager implements MissionManagerInterface
{
    /**
     * @var DocumentManager
     */
    protected $dm;

    /**
     * @var TimeManagerInterface
     */
    protected $timeManager;

    /**
     * @var HoustonInterface
     */
    protected $houston;

    /**
     * @var MissionLoggerInterface
     */
    protected $logger;

    /**
     * @param DocumentManager      $dm
     * @param TimeManagerInterface $timeManager
     * @param HoustonInterface      $houston
     */
    public function __construct(DocumentManager $dm, TimeManagerInterface $timeManager, HoustonInterface $houston)
    {
        $this->dm = $dm;
        $this->timeManager = $timeManager;
        $this->houston = $houston;
    }

    /**
     * @param MissionLoggerInterface $logger
     */
    public function setLogger(MissionLoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function createMission(Crew $crew)
    {
        $timestamp = $this->timeManager->getTime();
        $departureTime = $this->timeManager->generateDepartureTime();
        $missionEta = $this->timeManager->generateMissionEta();

        $mission = new Mission();
        $mission->setCrew($crew);
        $mission->setCreatedAt($timestamp);
        $mission->setDepartedAt($departureTime);
        $mission->setEta($missionEta);

        $this->dm->persist($mission);
        $this->dm->flush();

        return $mission;
    }

    /**
     * {@inheritdoc}
     */
    public function startMission(Mission $mission)
    {
        $mission->setStatus(Mission::STATUS_MISSION_ONGOING);

        $crew = $mission->getCrew();
        if (empty($crew)) {
            throw new \Exception("Mission has no crew");
        }
        $crew->setStatus(Crew::STATUS_FLYING);

        $this->dm->persist($mission);
        $this->dm->persist($crew);
        $this->dm->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function updateMissionStatus(Mission $mission)
    {
        $missionStatus = $this->houston->getMissionStatus($mission);
        switch ($missionStatus) {
            case HoustonInterface::MISSION_LANDED:
                $mission->setStatus(Mission::STATUS_MISSION_LANDED);
                $mission->setFinished(true);
                $this->dm->persist($mission);
                $this->dm->flush();
                $this->logger->logFinishedMission(Mission::STATUS_MISSION_LANDED);
                break;
            case HoustonInterface::MISSION_CRASHED:
                $mission->setStatus(Mission::STATUS_MISSION_CRASHED);
                $mission->setFinished(true);
                $this->dm->persist($mission);
                $this->dm->flush();
                $this->logger->logFinishedMission(Mission::STATUS_MISSION_CRASHED);
                break;
        }

        return $mission;
    }
}
