<?php

namespace TheCometCult\OdysseyBundle\Manager;

use TheCometCult\OdysseyBundle\Document\Mission;

interface MissionManagerInterface
{
    /**
     * @return Mission
     */
    public function createMission();

    /**
     * @param Mission $mission
     */
    public function startMission(Mission $mission);
}
