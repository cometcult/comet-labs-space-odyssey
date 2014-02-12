<?php

namespace spec\TheCometCult\OdysseyBundle\Manager;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TimeManagerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('TheCometCult\OdysseyBundle\Manager\TimeManagerInterface');
    }

    function it_should_return_time()
    {
        $this->getTime()->shouldBeInteger();
    }

    function it_should_generate_departure_time()
    {
        $this->generateDepartureTime()->shouldBeInteger();
    }
}
