<?php

namespace TheCometCult\OdysseyBundle\Logger;

use TheCometCult\OdysseyBundle\Document\Log;

interface MissionLoggerInterface
{
    /**
     * @param string $missionStatus
     *
     * @return Log
     */
    public function logFinishedMission($missionStatus);

    /**
     * @param string missionStatus
     *
     * @return string
     */
    public function getLogStatus($missionStatus);

    /**
     * @param string $logStatus
     *
     * @return Log
     */
    public function log($logStatus);
}
