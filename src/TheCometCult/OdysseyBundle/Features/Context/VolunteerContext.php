<?php

namespace TheCometCult\OdysseyBundle\Features\Context;

use Behat\MinkExtension\Context\MinkContext;

use TheCometCult\OdysseyBundle\Document\Volunteer;

class VolunteerContext extends MinkContext
{
    /**
     * @When /^I apply with "([^"]*)" email$/
     */
    public function iApplyWithEmail($email)
    {
    	$this->fillField('volunteer[email]', $email);
    	$this->pressButton('Save');
    }

    /**
     * @Given /^volunteer "([^"]*)" is already applied$/
     */
    public function volunteerIsAlreadyApplied($email)
    {
        $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();
        $volunteer = new Volunteer();
        $volunteer->setEmail($email);

    	$dm->persist($volunteer);
    	$dm->flush();
    }

    protected function getContainer()
    {
        return $this->getMainContext()->getContainer();
    }
}