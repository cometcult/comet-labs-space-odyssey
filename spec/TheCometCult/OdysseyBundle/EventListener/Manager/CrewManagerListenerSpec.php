<?php

namespace spec\TheCometCult\OdysseyBundle\EventListener\Manager;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CrewManagerListenerSpec extends ObjectBehavior
{
    /**
     * @param TheCometCult\OdysseyBundle\Manager\CrewManagerInterface $crewManager
     */
    function let($crewManager)
    {
        $this->beConstructedWith($crewManager);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('TheCometCult\OdysseyBundle\EventListener\Manager\CrewManagerListener');
    }

    /**
     * @param TheCometCult\OdysseyBundle\Event\VolunteerRegisteredEvent $event
     * @param TheCometCult\OdysseyBundle\Manager\CrewManagerInterface $crewManager
     */
    function it_should_create_crew_when_crew_limit_reached($event, $crewManager)
    {
        $crewManager->isCrewSizeLimitReached()->shouldBeCalled()->willReturn(true);
        $crewManager->createCrew()->shouldBeCalled();

        $this->onVolunteerRegistered($event);
    }
}
