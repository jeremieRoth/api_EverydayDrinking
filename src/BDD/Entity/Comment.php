<?php

namespace everydayDrinking\BDD\Entity;

class Comment
{
    private $id;
    private $user;
    private $comment;
    private $score;
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