<?php

namespace TheCometCult\OdysseyBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document
 */
class Crew
{
    /**
     * @const STATUS_READY_TO_FLY crew is ready to fly
     */
    const STATUS_READY_TO_FLY = 'ready_to_fly';

    /**
     * @const STATUS_FLYING crew is currently flying
     */
    const STATUS_FLYING = 'flying';

    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;

    /**
     * @MongoDB\String
     * @Assert\NotBlank
     */
    protected $status;

    /**
     * @MongoDB\ReferenceMany(targetDocument="TheCometCult\OdysseyBundle\Document\Volunteer")
     */
    protected $volunteers;

    public function __construct()
    {
        $this->volunteers = new ArrayCollection();
        $this->status = self::STATUS_READY_TO_FLY;
    }

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set status
     *
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add volunteer
     *
     * @param Volunteer $volunteer
     */
    public function addVolunteer($volunteer)
    {
        $this->volunteers[] = $volunteer;
    }

    /**
     * @param array
     */
    public function addVolunteers($volunteers)
    {
        foreach ($volunteers as $volunteer) {
            $this->addVolunteer($volunteer);
        }
    }

    /**
     * Remove volunteer
     *
     * @param Volunteer $volunteer
     */
    public function removeVolunteer(Volunteer $volunteer)
    {
        $this->volunteers->removeElement($volunteer);
    }

    /**
     * Get volunteers
     *
     * @return ArrayCollection
     */
    public function getVolunteers()
    {
        return $this->volunteers;
    }
}
