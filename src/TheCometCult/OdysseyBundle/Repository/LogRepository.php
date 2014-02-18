<?php

namespace TheCometCult\OdysseyBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

use TheCometCult\OdysseyBundle\Document\Log;

class LogRepository extends DocumentRepository
{
    /**
     * @return int
     */
    public function countLandedMissions()
    {
        return $this->createQueryBuilder()
            ->field('status')->equals(Log::MISSION_LANDED)
            ->getQuery()
            ->count();
    }

    /**
     * @return int
     */
    public function countCrashedMissions()
    {
        return $this->createQueryBuilder()
            ->field('status')->equals(Log::MISSION_CRASHED)
            ->getQuery()
            ->count();
    }
}
