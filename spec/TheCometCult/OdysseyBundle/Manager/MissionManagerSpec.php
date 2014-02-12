<?php

namespace spec\TheCometCult\OdysseyBundle\Manager;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use TheCometCult\OdysseyBundle\Document\Mission;
use TheCometCult\OdysseyBundle\Document\Crew;

class MissionManagerSpec extends ObjectBehavior
{
    /**
     * @param Doctrine\ODM\MongoDB\DocumentManager $dm
     * @param TheCometCult\OdysseyBundle\Manager\TimeManagerInterface $timeManeger
     */
    function let($dm, $timeManeger)
    {
        $this->beConstructedWith($dm, $timeManeger);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('TheCometCult\OdysseyBundle\Manager\MissionManager');
    }

    /**
     * @param Doctrine\ODM\MongoDB\DocumentManager $dm
     * @param TheCometCult\OdysseyBundle\Manager\TimeManagerInterface $timeManeger
     */
    function it_should_create_missions($dm, $timeManeger)
    {
        $timeManeger->getTime()->willReturn(1391431470);
        $timeManeger->generateDepartureTime()->willReturn(1391432910);
        $dm->persist(Argument::type('TheCometCult\OdysseyBundle\Document\Mission'))->shouldBeCalled();
        $dm->flush()->shouldBeCalled();

        $mission = $this->createMission();
        $mission->getCreatedAtTimestamp()->shouldReturn(1391431470);
        $mission->getDepartedAtTimestamp()->shouldReturn(1391432910);
        $mission->getStatus()->shouldReturn('mission_countdown');
    }

    /**
     * @param Doctrine\ODM\MongoDB\DocumentManager $dm
     * @param TheCometCult\OdysseyBundle\Document\Mission $mission
     * @param TheCometCult\OdysseyBundle\Document\Crew $crew
     */
    function it_should_start_missions($dm, $mission, $crew)
    {
        $mission->setStatus(Mission::STATUS_MISSION_ONGOING)->shouldBeCalled();
        $mission->getCrew()->willReturn($crew);

        $crew->setStatus(Crew::STATUS_FLYING)->shouldBeCalled();

        $dm->persist($mission)->shouldBeCalled();
        $dm->persist($crew)->shouldBeCalled();
        $dm->flush()->shouldBeCalled();

        $this->startMission($mission);
    }
}
