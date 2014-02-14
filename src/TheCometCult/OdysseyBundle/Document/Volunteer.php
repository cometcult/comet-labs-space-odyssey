<?php

namespace TheCometCult\OdysseyBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique as MongoDBUnique;

/**
 * @MongoDB\Document(repositoryClass="TheCometCult\OdysseyBundle\Repository\VolunteerRepository")
 * @MongoDBUnique(fields="email", message="Volunteer already applied.")
 */
class Volunteer
{
    const STATUS_ADMITTED = 'status_admitted';
    const STATUS_ASSIGNED_TO_CREW = 'status_assigned_to_crew';

    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;

    /**
     * @MongoDB\String
     * @Assert\NotBlank
     * @Assert\Email
     */
    protected $email;

    /**
     * @MongoDB\String
     */
    protected $status;

    public function __constuct()
    {
        $this->status = self::STATUS_ADMITTED;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
