<?php

namespace TheCometCult\OdysseyBundle\EventListener\Mailer;

use TheCometCult\OdysseyBundle\Mailer\NotificationMailerInterface;
use TheCometCult\OdysseyBundle\Event\CrewCreatedEvent;

/**
 * NotificationListner
 */
class NotificationListner
{
    /**
     * @var NotificationMailerInterface
     */
    protected $notificationMailer;

    /**
     * @param NotificationMailerInterface $notificationMailer
     */
    public function __construct(NotificationMailerInterface $notificationMailer)
    {
        $this->notificationMailer = $notificationMailer;
    }

    /**
     * @param CrewCreatedEvent $crewCreatedEvent
     */
    public function onCrewCreated(CrewCreatedEvent $crewCreatedEvent)
    {
        $crew = $crewCreatedEvent->getCrew();
        $this->notificationMailer->sendPackingInstructionsToCrewMembers($crew);
    }
}
