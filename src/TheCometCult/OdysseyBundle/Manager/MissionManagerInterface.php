<?php

namespace TheCometCult\OdysseyBundle\Manager;

use TheCometCult\OdysseyBundle\Document\Mission;
use TheCometCult\OdysseyBundle\Document\Crew;

interface MissionManagerInterface
{
    /**
     * @param Crew $crew
     *
     * @return Mission
     */
    public function createMission(Crew $crew);

    /**
     * @param Mission $mission
     */
    public function startMission(Mission $mission);

    /**
     * @param Mission $mission
     *
     * @return Mission
     */
    public function updateMissionStatus(Mission $mission);
}
