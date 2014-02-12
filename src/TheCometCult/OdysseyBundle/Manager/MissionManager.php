<?php

namespace TheCometCult\OdysseyBundle\Manager;

use Doctrine\ODM\MongoDB\DocumentManager;

use TheCometCult\OdysseyBundle\Document\Mission;
use TheCometCult\OdysseyBundle\Document\Crew;
use TheCometCult\OdysseyBundle\Manager\TimeManagerInterface;

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
     * @param DocumentManager      $dm
     * @param TimeManagerInterface $timeManager
     */
    public function __construct(DocumentManager $dm, TimeManagerInterface $timeManager)
    {
        $this->dm = $dm;
        $this->timeManager = $timeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function createMission()
    {
        $timestamp = $this->timeManager->getTime();
        $departureTime = $this->timeManager->generateDepartureTime();

        $mission = new Mission();
        $mission->setCreatedAt($timestamp);
        $mission->setDepartedAt($departureTime);

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
        $crew->setStatus(Crew::STATUS_FLYING);

        $this->dm->persist($mission);
        $this->dm->persist($crew);
        $this->dm->flush();
    }
}
