<?php

namespace spec\TheCometCult\OdysseyBundle\Calculator;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use TheCometCult\OdysseyBundle\Document\Log;

class SuccessRateCalculatorSpec extends ObjectBehavior
{
    /**
     * @param TheCometCult\OdysseyBundle\Repository\LogRepository $logRepository
     */
    function let($logRepository)
    {
        $this->beConstructedWith($logRepository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('TheCometCult\OdysseyBundle\Calculator\SuccessRateCalculator');
    }

    /**
     * @param TheCometCult\OdysseyBundle\Repository\LogRepository $logRepository
     */
    function it_should_calculate_success_rate($logRepository)
    {
        $logRepository->countLandedMissions()->willReturn(2);
        $logRepository->countCrashedMissions()->willReturn(0);

        $this->calculateSuccessRate()->shouldReturn(100);

        $logRepository->countLandedMissions()->willReturn(1);
        $logRepository->countCrashedMissions()->willReturn(1);

        $this->calculateSuccessRate()->shouldReturn(50);

        $logRepository->countLandedMissions()->willReturn(0);
        $logRepository->countCrashedMissions()->willReturn(0);

        $this->calculateSuccessRate()->shouldReturn(00);
    }
}
