<?php

namespace TheCometCult\OdysseyBundle\Manager;

class TimeManager implements TimeManagerInterface
{
    /**
     * @return int
     */
    public function getTime()
    {
        return time();
    }
}
