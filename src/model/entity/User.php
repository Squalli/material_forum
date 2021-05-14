<?php
namespace App\Model\Entity;

use App\Core\AbstractEntity as AE;
use App\Core\EntityInterface;

class User extends AE implements EntityInterface
{
    private $id;
    private $username;
    private $email;
    private $created_at;
    private $role;
    private $avatar;
    
    private $nbtopics;
    private $nbposts;
    private $score;

    public function __construct($data){
        parent::hydrate($data, $this);
        $this->setScore();
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of created_at
     */ 
    public function getCreated_at($format = "d/m/Y H:i:s")
    {
        return $this->created_at->format($format);
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreated_at($created_at)
    {
        $this->created_at = new \DateTime($created_at);

        return $this;
    }
    

    /**
     * Get the value of username
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */ 
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    public function __toString()
    {
        return $this->username;
    }

    /**
     * Get the value of role
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @return  self
     */ 
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    public function hasRole($role)
    {
        return $this->role == $role;
    }

     /**
     * Get the value of avatar
     */ 
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set the value of avatar
     *
     * @return  self
     */ 
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get the value of nbtopics
     */ 
    public function getNbtopics()
    {
        return $this->nbtopics;
    }

    /**
     * Set the value of nbtopics
     *
     * @return  self
     */ 
    public function setNbtopics($nbtopics)
    {
        $this->nbtopics = $nbtopics;

        return $this;
    }

    /**
     * Get the value of nbposts
     */ 
    public function getNbposts()
    {
        return $this->nbposts;
    }

    /**
     * Set the value of nbposts
     *
     * @return  self
     */ 
    public function setNbposts($nbposts)
    {
        $this->nbposts = $nbposts;

        return $this;
    }

    public function getScore(){
        return $this->score;
    }

    public function setScore(){
        $scorePost = $this->nbposts * 2;
        $scoreTopic = $this->nbtopics * 10;

        $this->score = $scorePost+$scoreTopic;
    }

    public function getGrade(){

        $ranges = [
            "50"   => "noob", 
            "150"  => "amateur", 
            "500"  => "soldat", 
            "1000" => "chef"
        ];

        foreach($ranges as $minscore => $grade){
            if($minscore > $this->score){
                return $grade;
            }
            else continue;
        }
    }

}