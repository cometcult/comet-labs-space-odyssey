<?php

namespace TheCometCult\OdysseyBundle\Manager;

use TheCometCult\OdysseyBundle\Document\Volunteer;

interface CrewManagerInterface
{
    /**
     * @return boolean
     */
    public function isCrewSizeLimitReached();

    /**
     * @return Crew
     */
    public function createCrew();
}