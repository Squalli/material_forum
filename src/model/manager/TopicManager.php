<?php

namespace App\Model\Manager;

use App\Core\AbstractManager as AM;
use App\Core\ManagerInterface;

class TopicManager extends AM implements ManagerInterface
{
    public function __construct(){
        parent::connect();
    }

    public function getAll(){
        return $this->getResults(
            "App\Model\Entity\Topic",
            "SELECT * FROM topic_list ORDER BY created_at DESC"
        );
    }

    public function getOneById($id){
        return $this->getOneOrNullResult(
            "App\Model\Entity\Topic",
            "SELECT * FROM topic_list WHERE id = :num", 
            [
                ":num" => $id
            ]
        );
    }

    public function insertTopic($title, $user_id){
        $this->executeQuery(
            "INSERT INTO topic (title, user_id) VALUES (:title, :userid)",
            [
                ":title"  => $title,
                ":userid" => $user_id,
            ]
        );
        return $this->getLastInsertId();
    }

    public function updateLock($bool, $id){
        
        return $this->executeQuery(
            "UPDATE topic SET locked = :bool WHERE id = :num",
            [
                ":bool" => $bool ? '1' : '0',
                ":num"  => $id
            ]
        );
    }
}