<?php

namespace TheCometCult\OdysseyBundle\Calculator;

use Doctrine\ODM\MongoDB\DocumentManager;

use TheCometCult\OdysseyBundle\Repository\LogRepository;

class SuccessRateCalculator
{
    /**
     * @var LogRepository
     */
    protected $logRepository;

    /**
     * @param LogRepository $logRepository
     */
    public function __construct($logRepository)
    {
        $this->logRepository = $logRepository;
    }

    /**
     * @return int
     */
    public function calculateSuccessRate()
    {
        $landedMissions = $this->logRepository->countLandedMissions();
        $crashedMissions = $this->logRepository->countCrashedMissions();

        return !empty($landedMissions) ? ($landedMissions * 100) / ($landedMissions + $crashedMissions) : $landedMissions;
    }
}
