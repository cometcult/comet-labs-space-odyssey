<?php

namespace TheCometCult\OdysseyBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

use Symfony\Component\Validator\Constraints as Assert;

use DateTime;
use DateTimeZone;

/**
 * @MongoDB\Document
 */
class Mission
{
    const STATUS_MISSION_COUNTDOWN = 'mission_countdown';

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

    public function __construct()
    {
        $this->status = self::STATUS_MISSION_COUNTDOWN;
    }

    /**
     * @param int $timestamp
     */
    public function setCreatedAt($timestamp)
    {
        $this->createdAt = new DateTime(date('Y-m-d H:i:s', $timestamp));
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
}
