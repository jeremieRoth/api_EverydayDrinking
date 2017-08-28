<?php

namespace everydayDrinking\BDD\Entity;

class Event
{
    private $id;
    private $name;
    private $establishment;

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
    public function getEstablishment()
    {
        return $this->establishment;
    }
    public function setEstablishment($establishment)
    {
        $this->establishment = $establishment;
        return $this;
    }




}