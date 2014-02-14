<?php

namespace TheCometCult\OdysseyBundle\Manager;

class TimeManager implements TimeManagerInterface
{
    /**
     * @var int
     */
    protected $departureDelay;

    /**
     * @var int
     */
    protected $missionEta;

    /**
     * @param int $departureDelay
     */
    public function setDepartureDelay($departureDelay)
    {
        $this->departureDelay = $departureDelay;
    }

    /**
     * @param int $missonEta
     */
    public function setMissionEta($missonEta)
    {
        $this->missionEta = $missonEta;
    }

    /**
     * @return int
     */
    public function getDepartureDelay()
    {
        return $this->departureDelay;
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

    /**
     * @return int
     */
    public function generateMissionEta()
    {
        return time() + $this->missionEta;
    }
}
