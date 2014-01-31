<?php

namespace spec\TheCometCult\OdysseyBundle\Manager;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

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
    function it_should_start_countdown($dm, $timeManeger)
    {
        $timeManeger->getTime()->willReturn(1391431470);
        $dm->persist(Argument::type('TheCometCult\OdysseyBundle\Document\Mission'))->shouldBeCalled();
        $dm->flush()->shouldBeCalled();

        $mission = $this->createMission();
        $mission->getCreatedAtTimestamp()->shouldReturn(1391431470);
        $mission->getStatus()->shouldReturn('mission_countdown');
    }
}
