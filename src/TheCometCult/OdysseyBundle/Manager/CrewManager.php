<?php

namespace TheCometCult\OdysseyBundle\Manager;

use Doctrine\ODM\MongoDB\DocumentManager;

use TheCometCult\OdysseyBundle\Document\Volunteer;
use TheCometCult\OdysseyBundle\Document\Crew;
use TheCometCult\OdysseyBundle\Repository\VolunteerRepository;
use TheCometCult\OdysseyBundle\Manager\MissionManagerInterface;

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
     * @var MissionManagerInterface
     */
    protected $missionManager;

    /**
     * @param DocumentManager         $dm
     * @param VolunteerRepository     $volunteerRepository
     * @param int                     $crewSizeLimit
     * @param MissionManagerInterface $missionManager
     */
    public function __construct(DocumentManager $dm, VolunteerRepository $volunteerRepository, $crewSizeLimit, MissionManagerInterface $missionManager)
    {
        $this->dm = $dm;
        $this->volunteerRepository = $volunteerRepository;
        $this->crewSizeLimit = $crewSizeLimit;
        $this->missionManager = $missionManager;
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

        $this->missionManager->createMission();

        return $crew;
    }
}
