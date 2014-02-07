<?php

namespace TheCometCult\OdysseyBundle;

/**
 * CrewEvents
 */
final class CrewEvents
{
    /**
     * The crew.crew_created event is thrown each time
     * a crew is created
     *
     * The event listener receives an
     * TheCometCult\OdysseyBundle\Event\CrewCreatedEvent
     *
     * @var string
     */
    const EVENT_CREW_CREATED = 'crew.crew_created';
}