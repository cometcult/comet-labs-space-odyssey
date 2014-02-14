<?php

namespace spec\TheCometCult\OdysseyBundle\Mission\Checker;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FoursquareCheckerSpec extends ObjectBehavior
{
    /**
     * @param Foursquare\FoursquareAPIBundle\Manager\CheckinManager $checkinManager
     */
    function let($checkinManager)
    {
        $this->beConstructedWith($checkinManager);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('TheCometCult\OdysseyBundle\Mission\Checker\HoustonInterface');
    }

    /**
     * @param Foursquare\FoursquareAPIBundle\Manager\CheckinManager $checkinManager
     * @param TheCometCult\OdysseyBundle\Document\Mission $mission
     */
    function it_should_return_mission_status_landed($checkinManager, $mission)
    {
        $checkinManager->getMarsCheckins()->willReturn(array('volunteer1', 'voluneer2'));
        $this->getMissionStatus($mission)->shouldReturn('landed');
    }

    /**
     * @param Foursquare\FoursquareAPIBundle\Manager\CheckinManager $checkinManager
     * @param TheCometCult\OdysseyBundle\Document\Mission $mission
     */
    function it_should_return_mission_status_crashed($checkinManager, $mission)
    {
        $checkinManager->getMarsCheckins()->willReturn(array());
        $this->getMissionStatus($mission)->shouldReturn('crashed');
    }
}
