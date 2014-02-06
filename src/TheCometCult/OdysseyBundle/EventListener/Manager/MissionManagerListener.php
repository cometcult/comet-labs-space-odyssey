<?php

namespace TheCometCult\OdysseyBundle\EventListener\Manager;

use TheCometCult\OdysseyBundle\Manager\MissionManagerInterface;
use TheCometCult\OdysseyBundle\Event\CrewCreatedEvent;

/**
 * MissionManagerListener
 */
class MissionManagerListener
{
    /**
     * @var MissionManagerInterface
     */
    protected $missionManager;

    /**
     * @param MissionManagerInterface $missionManager
     */
    public function __construct(MissionManagerInterface $missionManager)
    {
        $this->missionManager = $missionManager;
    }

    /**
     * @param CrewCreatedEvent $crewCreatedEvent
     */
    public function onCrewCreated(CrewCreatedEvent $crewCreatedEvent)
    {
        $this->missionManager->createMission();
    }
}