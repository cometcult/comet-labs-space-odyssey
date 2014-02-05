<?php

namespace TheCometCult\OdysseyBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;

use TheCometCult\OdysseyBundle\Document\Volunteer;

class VolunteerRepository extends DocumentRepository
{
    /**
     * @return int
     */
    public function countAdmittedVolunteers()
    {
        return $this->createQueryBuilder()
            ->field('status')->equals(Volunteer::STATUS_ADMITTED)
            ->getQuery()
            ->count();
    }

    /**
     * @return ArrayCollection
     */
    public function getAdmittedVolunteers()
    {
        $volunteers  = $this->createQueryBuilder()
            ->field('status')->equals(Volunteer::STATUS_ADMITTED)
            ->getQuery()
            ->execute();

        return $volunteers;
    }
}
