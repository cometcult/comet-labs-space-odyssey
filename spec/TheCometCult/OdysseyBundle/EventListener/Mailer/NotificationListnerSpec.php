<?php

namespace spec\TheCometCult\OdysseyBundle\EventListener\Mailer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NotificationListnerSpec extends ObjectBehavior
{
    /**
     * @param TheCometCult\OdysseyBundle\Mailer\NotificationMailerInterface $notificationMailer
     */
    function let($notificationMailer)
    {
        $this->beConstructedWith($notificationMailer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('TheCometCult\OdysseyBundle\EventListener\Mailer\NotificationListner');
    }

    /**
     * @param TheCometCult\OdysseyBundle\Mailer\NotificationMailerInterface $notificationMailer
     * @param TheCometCult\OdysseyBundle\Event\CrewCreatedEvent $crewCreatedEvent
     * @param TheCometCult\OdysseyBundle\Document\Crew $crew
     */
    function it_should_send_packing_instructions_when_crew_is_created($notificationMailer, $crewCreatedEvent, $crew)
    {
        $crewCreatedEvent->getCrew()->willReturn($crew);
        $notificationMailer->sendPackingInstructionsToCrewMembers($crew)->shouldBeCalled();

        $this->onCrewCreated($crewCreatedEvent)->shouldReturn(null);
    }
}
