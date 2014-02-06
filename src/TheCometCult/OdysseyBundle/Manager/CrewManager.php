<?php

namespace TheCometCult\OdysseyBundle\Manager;

use Doctrine\ODM\MongoDB\DocumentManager;

use TheCometCult\OdysseyBundle\Document\Volunteer;
use TheCometCult\OdysseyBundle\Document\Crew;
use TheCometCult\OdysseyBundle\Repository\VolunteerRepository;
use TheCometCult\OdysseyBundle\Event\CrewCreatedEvent;
use TheCometCult\OdysseyBundle\CrewEvents;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Exception;

class CrewManager implements CrewManagerInterface
{
    const VOLUNTEER_REGISTERED = 'volunteer_registered';

    /**
     * @var DocumentManager
     */
    protected $dm;

    /**
     * @var VolunteerRepository
     */
    protected $volunteerRepository;

    /**
     * @var int
     */
    protected $crewSizeLimit;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @param DocumentManager           $dm
     * @param VolunteerRepository       $volunteerRepository
     * @param int                       $crewSizeLimit
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(
        DocumentManager $dm,
        VolunteerRepository $volunteerRepository,
        $crewSizeLimit,
        EventDispatcherInterface $dispatcher
    )
    {
        $this->dm = $dm;
        $this->volunteerRepository = $volunteerRepository;
        $this->crewSizeLimit = $crewSizeLimit;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @return boolean
     */
    public function isCrewSizeLimitReached()
    {
        $numberOfVolunteers = $this->volunteerRepository->countAdmittedVolunteers();

        return $numberOfVolunteers >= $this->crewSizeLimit;
    }

    /**
     * @return Crew
     */
    public function createCrew()
    {
        $crew = new Crew();
        $volunteers = $this->volunteerRepository->getAdmittedVolunteers();
        if (empty($volunteers)) {
            throw new Exception("No volunteers");
        }
        foreach ($volunteers as $volunteer) {
            $volunteer->setStatus(Volunteer::STATUS_ASSIGNED_TO_CREW);
            $this->dm->persist($volunteer);
        }
        $crew->addVolunteers($volunteers);
        $this->dm->persist($crew);
        $this->dm->flush();

        $this->dispatcher->dispatch(
            CrewEvents::EVENT_CREW_CREATED,
            new CrewCreatedEvent($crew)
        );

        return $crew;
    }
}
