<?php

namespace TheCometCult\OdysseyBundle\Features\Context;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Exception\BehaviorException;

use TheCometCult\OdysseyBundle\Document\Crew;
use TheCometCult\OdysseyBundle\Document\Volunteer;

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

    /**
     * @Given /^a ready to fly crew exists$/
     */
    public function aReadyToFlyCrewExists()
    {
        $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();
        $crewSize = $this->getContainer()->getParameter('the_comet_cult_odyssey.crew_size');

        $crew = new Crew();
        for ($i = 0; $i < $crewSize; $i++) {
            $volunteer = new Volunteer();
            $volunteer->setEmail('test' . $i . '@test.com');
            $volunteer->setStatus(Volunteer::STATUS_ASSIGNED_TO_CREW);

            $dm->persist($volunteer);

            $crew->addVolunteer($volunteer);
        }
        $dm->persist($crew);
        $dm->flush();
    }

    /**
     * @Given /^the crew should be flying$/
     */
    public function theCrewShouldBeFlying()
    {
        $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();
        $flyingCrewsNumber = $dm->createQueryBuilder('TheCometCultOdysseyBundle:Crew')
            ->field('status')->equals(Crew::STATUS_FLYING)
            ->getQuery()
            ->count();

        if ($flyingCrewsNumber < 1) {
            throw new BehaviorException('There are no flying crews');
        }
    }

    protected function getContainer()
    {
        return $this->getMainContext()->getContainer();
    }
}
