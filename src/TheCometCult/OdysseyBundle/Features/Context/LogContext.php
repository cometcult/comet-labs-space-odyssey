<?php

namespace TheCometCult\OdysseyBundle\Features\Context;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Exception\BehaviorException;

use TheCometCult\OdysseyBundle\Document\Mission;
use TheCometCult\OdysseyBundle\Document\Log;

class LogContext extends BehatContext
{
    /**
     * @Given /^log about finished mission should exist$/
     */
    public function logAboutFinishedMissionShouldExist()
    {
        $this->checkLog(Log::MISSION_LANDED);
    }

    /**
     * @Given /^log about crashed mission should exist$/
     */
    public function logAboutCrashedMissionShouldExist()
    {
        $this->checkLog(Log::MISSION_CRASHED);
    }

    protected function checkLog($logStatus)
    {
        $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();
        $landedLog = $dm->createQueryBuilder('TheCometCultOdysseyBundle:Log')
            ->field('status')->equals($logStatus)
            ->getQuery()
            ->count();

        if ($landedLog < 1) {
            throw new BehaviorException(sprintf('There are no logged %s', $logStatus));
        }
    }

    /**
     * @Given /^there are (\d+) logs "([^"]*)"$/
     */
    public function thereAreLogs($number, $logStatus)
    {
        if (!in_array($logStatus, array(Log::MISSION_LANDED, Log::MISSION_CRASHED))) {
            throw new BehaviorException(sprintf('Invalid log status: %s', $logStatus));
        }
        $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();
        for ($i=0; $i < $number; $i++) {
            $log = new Log();
            $log->setStatus($logStatus);
            $dm->persist($log);
        }
        $dm->flush();
    }

    protected function getContainer()
    {
        return $this->getMainContext()->getContainer();
    }
}
