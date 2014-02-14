<?php

namespace Foursquare\FoursquareAPIBundle\Manager;

/**
 * CheckinManager
 */
class CheckinManager
{
    /**
     * @var array
     */
    protected $marsCheckins = array();

    /**
     * @return array
     */
    public function getMarsCheckins()
    {
        return $this->marsCheckins;
    }
}
