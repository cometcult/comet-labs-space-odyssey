<?php

namespace TheCometCult\OdysseyBundle\Features\Context;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Exception\BehaviorException;
use Behat\Behat\Exception\PendingException;

use TheCometCult\OdysseyBundle\Document\Mission;

class MissionContext extends BehatContext
{
    /**
     * @Given /^misson launch time should start countdown$/
     */
    public function missonLaunchTimeShouldStartCountdown()
    {
        $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();
        $missionCountingDown = $dm->createQueryBuilder('TheCometCultOdysseyBundle:Mission')
            ->field('status')->equals(Mission::STATUS_MISSION_COUNTDOWN)
            ->getQuery()
            ->count();

        if ($missionCountingDown < 1) {
            throw new BehaviorException('There are no missions counting down');
        }
    }

    protected function getContainer()
    {
        return $this->getMainContext()->getContainer();
    }
}
