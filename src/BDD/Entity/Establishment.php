<?php

namespace everydayDrinking\BDD\Entity;

class Establishment
{
    /**
    *Establishment id
    *
    *@var integer
    */
    private $id;
  /**
    * Establishment name
    *
    *@var String
    */
    private $name;
  /**
    * Establishment location
    *
    *@var Location
    */
    private $location;

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

    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getLocation()
    {
        return $this->location;
    }
    public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }



}