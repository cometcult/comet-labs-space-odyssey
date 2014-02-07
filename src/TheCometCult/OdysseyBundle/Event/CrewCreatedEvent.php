<?php

namespace TheCometCult\OdysseyBundle\Event;

use Symfony\Component\EventDispatcher\Event;

use TheCometCult\OdysseyBundle\Document\Crew;

/**
 * CrewCreatedEvent
 */
class CrewCreatedEvent extends Event
{
    /**
     * @var Crew
     */
    protected $crew;

    /**
     * @param Crew $crew
     */
    public function __construct(Crew $crew)
    {
        $this->crew = $crew;
    }

    /**
     * @return Crew
     */
    public function getCrew()
    {
        return $this->crew;
    }
}
