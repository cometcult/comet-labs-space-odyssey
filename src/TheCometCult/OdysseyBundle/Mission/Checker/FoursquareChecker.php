<?php

namespace TheCometCult\OdysseyBundle\Mission\Checker;

use TheCometCult\OdysseyBundle\Document\Mission;
use Foursquare\FoursquareAPIBundle\Manager\CheckinManager;

class FoursquareChecker implements HoustonInterface
{
    /**
     * @var CheckinManager
     */
    protected $foursquareApi;

    /**
     * @param CheckinManager $api
     */
    public function __construct(CheckinManager $api)
    {
        $this->foursquareApi = $api;
    }

    /**
     * {@inheritDoc}
     */
    public function getMissionStatus(Mission $mission)
    {
        $marsCheckIns = $this->countMarsCheckins();
        if (!empty($marsCheckIns)) {
            return self::MISSION_LANDED;
        } else {
            return self::MISSION_CRASHED;
        }
    }

    public function countMarsCheckins()
    {
        return count($this->foursquareApi->getMarsCheckins());
    }
}
