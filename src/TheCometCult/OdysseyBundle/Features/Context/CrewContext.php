<?php

namespace TheCometCult\OdysseyBundle\Features\Context;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Exception\BehaviorException;

use TheCometCult\OdysseyBundle\Document\Crew;

class CrewContext extends BehatContext
{
    /**
     * @Then /^a ready to fly crew should be created$/
     */
    public function aReadyToFlyCrewShouldBeCreated()
    {
        $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();
        $readyToFlyCrewsNumber = $dm->createQueryBuilder('TheCometCultOdysseyBundle:Crew')
            ->field('status')->equals(Crew::STATUS_READY_TO_FLY)
            ->getQuery()
            ->count();

        if ($readyToFlyCrewsNumber < 1) {
            throw new BehaviorException('There are no ready to fly crews');
        }
    }

    protected function getContainer()
    {
        return $this->getMainContext()->getContainer();
    }
}