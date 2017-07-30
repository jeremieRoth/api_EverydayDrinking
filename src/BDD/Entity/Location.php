<?php

namespace api_EverydayDrinking\BDD\Entity\Entity;

class Location
{
    private $id;
    private $longitude;
    private $latitude;
    private $etablishment;

    public function __construct(){}

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function getEtablishment()
    {
        return $this->etablishment;
    }
    public function setEtablishment($etablishment)
    {
        $this->etablishment = $etablishment;
        return $this;
    }

}