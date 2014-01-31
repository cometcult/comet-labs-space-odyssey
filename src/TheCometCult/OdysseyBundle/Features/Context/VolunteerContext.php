<?php

namespace TheCometCult\OdysseyBundle\Features\Context;

use Behat\MinkExtension\Context\MinkContext;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Exception\BehaviorException;

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

    /**
     * @Given /^there are admitted volunteers:$/
     */
    public function thereAreAdmittedVolunteers(TableNode $volunteersTable)
    {
        $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();
        foreach ($volunteersTable->getHash() as $volunteerColumn) {
            $volunteer = new Volunteer();
            if (!empty($volunteerColumn['email'])) {
                $volunteer->setEmail($volunteerColumn['email']);
            }
            $volunteer->setStatus(Volunteer::STATUS_ADMITTED);
            $dm->persist($volunteer);
        }
        $dm->flush();
    }

    /**
     * @Given /^volunteers should be assigned to crew:$/
     */
    public function volunteersShouldBeAssignedToCrew(TableNode $volunteersTable)
    {
        $dm = $this->getContainer()->get('doctrine_mongodb')->getManager();
        foreach ($volunteersTable->getHash() as $volunteerColumn) {
            $assignedVolunteer = $dm->createQueryBuilder('TheCometCultOdysseyBundle:Volunteer')
                ->field('status')->equals(Volunteer::STATUS_ASSIGNED_TO_CREW)
                ->field('email')->equals($volunteerColumn['email'])
                ->getQuery()
                ->getSingleResult();
            if (empty($assignedVolunteer)) {
                throw new BehaviorException(sprintf('Volunteer %s is not admitted', $volunteerColumn['email']));
            }
        }
    }

    protected function getContainer()
    {
        return $this->getMainContext()->getContainer();
    }
}