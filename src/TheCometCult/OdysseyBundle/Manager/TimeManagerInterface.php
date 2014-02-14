<?php

namespace TheCometCult\OdysseyBundle\Manager;

interface TimeManagerInterface
{
    /**
     * @return int
     */
    public function getTime();

    /**
     * @return int
     */
    public function generateDepartureTime();

    /**
     * @return int
     */
    public function generateMissionEta();
}
