<?php
namespace App\Model\Entity;

use App\Core\EntityInterface;
use App\Core\AbstractEntity as AE;

class Post extends AE implements EntityInterface
{
    private $id;
    private $text;
    private $created_at;
    private $user;

    public function __construct($data){
        parent::hydrate($data, $this);
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
     * Get the value of text
     */ 
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set the value of text
     *
     * @return  self
     */ 
    public function setText($text)
    {
        $this->text = $text;

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
     * Get the value of user
     */ 
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */ 
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }
}