<?php

namespace api_EverydayDrinking\BDD\Entity\Entity;

class Drink
{
    private $id;
    private $name;
    private $price;
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

    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

        public function getPrice()
    {
        return $this->price;
    }
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

        public function getEtablishement()
    {
        return $this->etablishement;
    }
    public function setEtablishement($etablishement)
    {
        $this->etablishement = $etablishement;
        return $this;
    }


}
