<?php

namespace TheCometCult\OdysseyBundle\Logger;

use Doctrine\ODM\MongoDB\DocumentManager;

use TheCometCult\OdysseyBundle\Document\Log;
use TheCometCult\OdysseyBundle\Document\Mission;

class MissionLogger implements MissionLoggerInterface
{
    /**
     * @param DocumentManager $dm
     */
    public function __construct($dm)
    {
        $this->dm = $dm;
    }

    /**
     * {@inheritdoc}
     */
    public function log($logStatus)
    {
        $log = new Log();
        $log->setStatus($logStatus);
        $this->dm->persist($log);
        $this->dm->flush();

        return $log;
    }

    /**
     * {@inheritdoc}
     */
    public function logFinishedMission($missionStatus)
    {
        $logStatus = $this->getLogStatus($missionStatus);

        return $this->log($logStatus);
    }

    /**
     * {@inheritdoc}
     */
    public function getLogStatus($missionStatus)
    {
        $logStatus = null;
        switch ($missionStatus) {
            case Mission::STATUS_MISSION_LANDED:
                $logStatus = Log::MISSION_LANDED;
                break;
            case Mission::STATUS_MISSION_CRASHED:
                $logStatus = Log::MISSION_CRASHED;
                break;
        }

        return $logStatus;
    }
}
