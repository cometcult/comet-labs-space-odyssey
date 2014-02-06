<?php

namespace TheCometCult\OdysseyBundle;

/**
 * VolunteerEvents
 */
final class VolunteerEvents
{
    /**
     * The volunteer.volunteer_registered event is thrown each time
     * a volunteer is registered
     *
     * The event listener receives an
     * TheCometCult\OdysseyBundle\Event\VolunteerRegisteredEvent
     *
     * @var string
     */
    const EVENT_VOLUNTEER_REGISTERED = 'volunteer.volunteer_registered';
}