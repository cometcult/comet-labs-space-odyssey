<?php

namespace TheCometCult\OdysseyBundle\Manager;

class TimeManager implements TimeManagerInterface
{
    protected $departureDelay;

    /**
     * @param int $departureDelay
     */
    public function setDepartureDelay($departureDelay)
    {
        $this->departureDelay = $departureDelay;
    }

    /**
     * @return int
     */
    public function getTime()
    {
        return time();
    }

    /**
     * @return int
     */
    public function generateDepartureTime()
    {
        return time() + $this->departureDelay;
    }
}
