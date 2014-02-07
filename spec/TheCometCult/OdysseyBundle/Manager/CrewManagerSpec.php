<?php

namespace spec\TheCometCult\OdysseyBundle\Manager;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use TheCometCult\OdysseyBundle\Manager\CrewManagerInterface;
use TheCometCult\OdysseyBundle\Document\Crew;

use Doctrine\Common\Collections\ArrayCollection;

class CrewManagerSpec extends ObjectBehavior
{
    /**
     * @param Doctrine\ODM\MongoDB\DocumentManager $dm
     * @param TheCometCult\OdysseyBundle\Repository\VolunteerRepository $volunteerRepository
     * @param Symfony\Component\EventDispatcher\EventDispatcherInterface $dispatcher
     */
    function let($dm, $volunteerRepository, $dispatcher)
    {
        $this->beConstructedWith($dm, $volunteerRepository, 5, $dispatcher);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('TheCometCult\OdysseyBundle\Manager\CrewManagerInterface');
    }

    /**
     * @param TheCometCult\OdysseyBundle\Repository\VolunteerRepository $volunteerRepository
     */
    function it_should_report_when_crew_size_limit_reached($volunteerRepository)
    {
        $volunteerRepository->countAdmittedVolunteers()->shouldBeCalled()->willReturn(5);
        $this->isCrewSizeLimitReached()->shouldReturn(true);
    }

    /**
     * @param TheCometCult\OdysseyBundle\Repository\VolunteerRepository $volunteerRepository
     */
    function it_should_report_when_crew_size_limit_not_reached($volunteerRepository)
    {
        $volunteerRepository->countAdmittedVolunteers()->shouldBeCalled()->willReturn(0);
        $this->isCrewSizeLimitReached()->shouldReturn(false);
    }

    /**
     * @param TheCometCult\OdysseyBundle\Repository\VolunteerRepository $volunteerRepository
     * @param TheCometCult\OdysseyBundle\Document\Volunteer $volunteer1
     * @param TheCometCult\OdysseyBundle\Document\Volunteer $volunteer2
     * @param TheCometCult\OdysseyBundle\Document\Volunteer $volunteer3
     * @param TheCometCult\OdysseyBundle\Document\Volunteer $volunteer4
     * @param TheCometCult\OdysseyBundle\Document\Volunteer $volunteer5
     */
    function it_should_create_crew(
        $volunteerRepository,
        $volunteer1,
        $volunteer2,
        $volunteer3,
        $volunteer4,
        $volunteer5
    )
    {
        $volunteers = new ArrayCollection(array($volunteer1, $volunteer2, $volunteer3, $volunteer4, $volunteer5));
        $volunteerRepository->getAdmittedVolunteers()->willReturn($volunteers);

        $crew = $this->createCrew();
        $crew->getVolunteers()->shouldHaveType('Doctrine\Common\Collections\ArrayCollection');
        $crew->shouldHaveType('TheCometCult\OdysseyBundle\Document\Crew');
        $crew->getStatus()->shouldReturn(Crew::STATUS_READY_TO_FLY);
    }
}
