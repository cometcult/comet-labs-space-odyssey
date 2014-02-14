<?php

namespace spec\TheCometCult\OdysseyBundle\Manager;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use TheCometCult\OdysseyBundle\Document\Mission;
use TheCometCult\OdysseyBundle\Document\Crew;
use TheCometCult\OdysseyBundle\Mission\Checker\HoustonInterface;

class MissionManagerSpec extends ObjectBehavior
{
    /**
     * @param Doctrine\ODM\MongoDB\DocumentManager $dm
     * @param TheCometCult\OdysseyBundle\Manager\TimeManagerInterface $timeManeger
     * @param TheCometCult\OdysseyBundle\Mission\Checker\HoustonInterface $houston
     */
    function let($dm, $timeManeger, $houston)
    {
        $this->beConstructedWith($dm, $timeManeger, $houston);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('TheCometCult\OdysseyBundle\Manager\MissionManager');
    }

    /**
     * @param Doctrine\ODM\MongoDB\DocumentManager $dm
     * @param TheCometCult\OdysseyBundle\Manager\TimeManagerInterface $timeManeger
     * @param TheCometCult\OdysseyBundle\Document\Crew $crew
     */
    function it_should_create_missions($dm, $timeManeger, $crew)
    {
        $timeManeger->getTime()->shouldBeCalled()->willReturn(1391431470);
        $timeManeger->generateDepartureTime()->shouldBeCalled()->willReturn(1391432910);
        $timeManeger->generateMissionEta()->shouldBeCalled()->willReturn(1391433910);
        $dm->persist(Argument::type('TheCometCult\OdysseyBundle\Document\Mission'))->shouldBeCalled();
        $dm->flush()->shouldBeCalled();
        $mission = $this->createMission($crew);
        $mission->getCreatedAtTimestamp()->shouldReturn(1391431470);
        $mission->getDepartedAtTimestamp()->shouldReturn(1391432910);
        $mission->getEtaTimestamp()->shouldReturn(1391433910);
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

    /**
     * @param Doctrine\ODM\MongoDB\DocumentManager $dm
     * @param TheCometCult\OdysseyBundle\Document\Mission $mission
     * @param TheCometCult\OdysseyBundle\Mission\Checker\HoustonInterface $houston
     */
    function it_should_update_mission_status_to_landed($dm, $mission, $houston)
    {
        $houston->getMissionStatus($mission)->willReturn(HoustonInterface::MISSION_LANDED);
        $mission->setStatus(Mission::STATUS_MISSION_LANDED)->shouldBeCalled();
        $mission->setFinished(true)->shouldBeCalled();
        $dm->persist($mission)->shouldBeCalled();
        $dm->flush()->shouldBeCalled();
        $this->updateMissionStatus($mission)->shouldHaveType('TheCometCult\OdysseyBundle\Document\Mission');
    }

    /**
     * @param Doctrine\ODM\MongoDB\DocumentManager $dm
     * @param TheCometCult\OdysseyBundle\Document\Mission $mission
     * @param TheCometCult\OdysseyBundle\Mission\Checker\HoustonInterface $houston
     */
    function it_should_update_mission_status_to_crashed($dm, $mission, $houston)
    {
        $houston->getMissionStatus($mission)->willReturn(HoustonInterface::MISSION_CRASHED);
        $mission->setStatus(Mission::STATUS_MISSION_CRASHED)->shouldBeCalled();
        $mission->setFinished(true)->shouldBeCalled();
        $dm->persist($mission)->shouldBeCalled();
        $dm->flush()->shouldBeCalled();
        $this->updateMissionStatus($mission)->shouldHaveType('TheCometCult\OdysseyBundle\Document\Mission');
    }

    /**
     * @param TheCometCult\OdysseyBundle\Document\Mission $mission
     * @param TheCometCult\OdysseyBundle\Mission\Checker\HoustonInterface $houston
     */
    function it_should_update_mission_status_to_ongoing($dm, $mission, $houston)
    {
        $houston->getMissionStatus($mission)->willReturn(null);
        $mission->setStatus(Argument::any())->shouldNotBeCalled();
        $mission->setFinished(Argument::any())->shouldNotBeCalled();
        $this->updateMissionStatus($mission)->shouldHaveType('TheCometCult\OdysseyBundle\Document\Mission');
    }
}
