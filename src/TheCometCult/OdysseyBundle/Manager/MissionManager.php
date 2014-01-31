<?php

namespace TheCometCult\OdysseyBundle\Manager;

use Doctrine\ODM\MongoDB\DocumentManager;

use TheCometCult\OdysseyBundle\Document\Mission;
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
     * @return Mission
     */
    public function createMission()
    {
        $mission = new Mission();
        $timestamp = $this->timeManager->getTime();
        $mission->setCreatedAt($timestamp);
        $this->dm->persist($mission);
        $this->dm->flush();

        return $mission;
    }
}
