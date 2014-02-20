<?php

namespace Foursquare\FoursquareAPIBundle\Manager;

/**
 * CheckinManager
 */
class CheckinManager
{
    /**
     * @return array
     */
    public function getMarsCheckins()
    {
        return $this->getRandomizedMarsCheckins();
    }

    protected function getRandomizedMarsCheckins()
    {
        $fooCheckins = array();
        $fooCheckinsNumber = rand(0, 5);
        for ($i=0; $i < $fooCheckinsNumber; $i++) {
            array_push($fooCheckins, 'checkin');
        }

        return $fooCheckins;
    }
}
