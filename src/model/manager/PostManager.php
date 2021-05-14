<?php

namespace App\Model\Manager;

use App\Core\AbstractManager as AM;
use App\Core\ManagerInterface;

class PostManager extends AM implements ManagerInterface
{
    public function __construct(){
        parent::connect();
    }
    
    public function getAll(){
        return $this->getResults(
            "App\Model\Entity\Post",
            "SELECT * FROM post"
        );
    }

    public function getAllByTopic($topic_id, $pagination = ""){

        $sql = "SELECT * FROM post ".
               "WHERE topic_id = :num ".
               "ORDER BY created_at ASC ".
               $pagination;
        
        return $this->getResults(
            "App\Model\Entity\Post",
            $sql, 
            [
                ":num" => $topic_id
            ]
        );
    }

    public function getOneById($id){
        return $this->getOneOrNullResult(
            "App\Model\Entity\Post",
            "SELECT * FROM post WHERE id = :num", 
            [
                ":num" => $id
            ]
        );
    }

    public function insertPost($text, $topic_id, $user_id){
        return $this->executeQuery(
            "INSERT INTO post (text, topic_id, user_id) VALUES (:text, :topicid, :userid)",
            [
                ":text"    => $text,
                ":topicid" => $topic_id,
                ":userid"  => $user_id,
            ]
        );   
    }
}