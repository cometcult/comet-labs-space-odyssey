<?php

namespace TheCometCult\OdysseyBundle\EventListener\Manager;

use TheCometCult\OdysseyBundle\Event\VolunteerRegisteredEvent;
use TheCometCult\OdysseyBundle\Manager\CrewManagerInterface;

class CrewManagerListener
{
    /**
     * @var CrewManagerInterface
     */
    protected $crewManager;

    /**
     * @param CrewManagerInterface $crewManager
     */
    public function __construct(CrewManagerInterface $crewManager)
    {
        $this->crewManager = $crewManager;
    }

    /**
     * @param VolunteerRegisteredEvent $event
     */
    public function onVolunteerRegistered(VolunteerRegisteredEvent $event)
    {
        $limitReached = $this->crewManager->isCrewSizeLimitReached();
        if (!empty($limitReached)) {
            $crew = $this->crewManager->createCrew();
        }
    }
}
