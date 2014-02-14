<?php

namespace spec\Foursquare\FoursquareAPIBundle\Manager;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CheckinManagerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Foursquare\FoursquareAPIBundle\Manager\CheckinManager');
    }

    function it_should_return_mars_checkins()
    {
        $this->getMarsCheckins()->shouldReturn(array());
    }
}
