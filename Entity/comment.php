<?php

class comment
{
    private $id;
    private $user;
    private $comment;
    private $score;
    private $etablishement;

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

    public function getUser()
    {
        return $this->user;
    }
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    public function getComment()
    {
        return $this->comment;
    }
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    public function getScore()
    {
        return $this->score;
    }
    public function setScore($score)
    {
        $this->score = $score;
        return $this;
    }

    public function getEtablishment()
    {
        return $this->etablishment;
    }
    public function setEtablishement($etablishment)
    {
        $this->etablishment = $etablishment;
        return $this;
    }




}