<?php

namespace TheCometCult\OdysseyBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(repositoryClass="TheCometCult\OdysseyBundle\Repository\LogRepository")
 */
class Log
{
    /**
     * @constant MISSION_LANDED logs landed mission
     */
    const MISSION_LANDED = 'mission landed';

    /**
     * @constant MISSION_CRASHED logs landed mission
     */
    const MISSION_CRASHED = 'mission crashed';

    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;

    /**
     * @MongoDB\String
     */
    protected $status;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
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
