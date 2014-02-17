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

    protected function getContainer()
    {
        return $this->getMainContext()->getContainer();
    }
}
