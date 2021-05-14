<?php

namespace App\Model\Entity;

use App\Core\EntityInterface;
use App\Core\AbstractEntity as AE;

class Topic extends AE implements EntityInterface
{
    private $id;
    private $title;
    private $created_at;
    private $locked;
    private $user;
    private $nbposts;

    public function __construct($data)
    {
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
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

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
     * Get the value of locked
     */ 
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * Set the value of locked
     *
     * @return  self
     */ 
    public function setLocked($locked)
    {
        $this->locked = $locked;

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

    public function isAuthor($user)
    {
        return $this->user->getId() == $user->getId();
    }

    /**
     * Get the value of nb_messages
     */ 
    public function getNbposts()
    {
        return $this->nbposts;
    }

    /**
     * Set the value of nb_messages
     *
     * @return  self
     */ 
    public function setNbposts($nb_posts)
    {
        $this->nbposts = $nb_posts;

        return $this;
    }
}