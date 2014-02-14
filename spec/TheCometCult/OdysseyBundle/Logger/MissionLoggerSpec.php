<?php

namespace spec\TheCometCult\OdysseyBundle\Logger;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use TheCometCult\OdysseyBundle\Document\Log;
use TheCometCult\OdysseyBundle\Document\Mission;

class MissionLoggerSpec extends ObjectBehavior
{
    /**
     * @param Doctrine\ODM\MongoDB\DocumentManager $dm
     */
    function let($dm)
    {
        $this->beConstructedWith($dm);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('TheCometCult\OdysseyBundle\Logger\MissionLoggerInterface');
    }

    /**
     * @param Doctrine\ODM\MongoDB\DocumentManager $dm
     * @param TheCometCult\OdysseyBundle\Document\Log $log
     */
    function it_should_log_landed_mission($dm, $log)
    {
        $dm->persist(Argument::type('TheCometCult\OdysseyBundle\Document\Log'))->shouldBeCalled();
        $dm->flush()->shouldBeCalled();
        $this->logFinishedMission(Mission::STATUS_MISSION_LANDED)->shouldHaveType('TheCometCult\OdysseyBundle\Document\Log');
    }

    /**
     * @param Doctrine\ODM\MongoDB\DocumentManager $dm
     * @param TheCometCult\OdysseyBundle\Document\Log $log
     */
    function it_should_log_crashed_mission($dm, $log)
    {
        $dm->persist(Argument::type('TheCometCult\OdysseyBundle\Document\Log'))->shouldBeCalled();
        $dm->flush()->shouldBeCalled();
        $this->logFinishedMission(Mission::STATUS_MISSION_CRASHED)->shouldHaveType('TheCometCult\OdysseyBundle\Document\Log');
    }

    function it_should_return_log_status_when_mission_crashed()
    {
        $this->getLogStatus(Mission::STATUS_MISSION_CRASHED)->shouldReturn(Log::MISSION_CRASHED);
    }

    function it_should_return_log_status_when_mission_landed()
    {
        $this->getLogStatus(Mission::STATUS_MISSION_LANDED)->shouldReturn(Log::MISSION_LANDED);
    }

    function it_should_create_log()
    {
        $this->log(Log::MISSION_LANDED)->shouldHaveType('TheCometCult\OdysseyBundle\Document\Log');
        $this->log(Log::MISSION_CRASHED)->shouldHaveType('TheCometCult\OdysseyBundle\Document\Log');
    }
}
