<?php

namespace TheCometCult\OdysseyBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @MongoDB\Document
 */
class Mission
{
    /**
     * @const STATUS_MISSION_COUNTDOWN countdown to mission start has began
     */
    const STATUS_MISSION_COUNTDOWN = 'mission_countdown';

    /**
     * @const STATUS_MISSION_ONGOING mission is currently ongoing
     */
    const STATUS_MISSION_ONGOING = 'mission_ongoing';

    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $status;

    /**
     * @MongoDB\Date
     */
    protected $createdAt;

    /**
     * @MongoDB\Date
     */
    protected $departedAt;

    /**
     * @MongoDB\ReferenceOne(targetDocument="TheCometCult\OdysseyBundle\Document\Crew")
     */
    protected $crew;

    public function __construct()
    {
        $this->status = self::STATUS_MISSION_COUNTDOWN;
    }

    /**
     * @param int $timestamp
     */
    public function setCreatedAt($timestamp)
    {
        $this->createdAt = new \DateTime(date('Y-m-d H:i:s', $timestamp));
    }

    /**
     * @return int
     */
    public function getCreatedAtTimestamp()
    {
        return $this->createdAt->getTimestamp();
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $timestamp
     */
    public function setDepartedAt($timestamp)
    {
        $this->departedAt = new \DateTime(date('Y-m-d H:i:s', $timestamp));
    }

    /**
     * @return int
     */
    public function getDepartedAtTimestamp()
    {
        return $this->departedAt->getTimestamp();
    }

    /**
     * @param Crew $crew
     */
    public function setCrew(Crew $crew)
    {
        $this->crew = $crew;
    }

    /**
     * @return Crew
     */
    public function getCrew()
    {
        return $this->crew;
    }
}
