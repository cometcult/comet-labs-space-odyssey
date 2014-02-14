<?php

namespace TheCometCult\OdysseyBundle\Mission\Checker;

use TheCometCult\OdysseyBundle\Document\Mission;

interface HoustonInterface
{
    /**
     * @const MISSION_LANDED mission landed
     */
    const MISSION_LANDED = 'landed';

    /**
     * @const MISSION_LANDED mission crashed
     */
    const MISSION_CRASHED = 'crashed';

    /**
     * @param Mission $mission
     *
     * @return string
     */
    public function getMissionStatus(Mission $mission);
}
