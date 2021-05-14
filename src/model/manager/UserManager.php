<?php
namespace App\Model\Manager;

use App\Core\AbstractManager as AM;
use App\Core\ManagerInterface;

class UserManager extends AM implements ManagerInterface
{
    public function __construct(){
        parent::connect();
    }

    public function getAll(){
        return;
    }

    public function countUsers(){
        return $this->getOneValue(
            "SELECT COUNT(id) FROM user",
        );
    }

    public function getList($pagination = ""){
        return $this->getResults(
            "App\Model\Entity\User",
            "SELECT * FROM user_list ORDER BY created_at DESC ".$pagination
        );
    }

    public function getOneById($id){
        return $this->getOneOrNullResult(
            "App\Model\Entity\User",
            "SELECT * FROM user_list WHERE id = :num", 
            [
                ":num" => $id
            ]
        );
    }

    public function getOneByCredentials(...$credentials){
        $sql = "SELECT * FROM user_list ";
        $params = [];
        foreach($credentials as $index => $cred){
            $param = ":cred".$index;
            $sql.= $index == 0 ? "WHERE " : "OR ";
            $sql.= "username = $param OR email = $param ";
            $params[$param] = $cred;
        }
        return $this->getOneOrNullResult(
            "App\Model\Entity\User",
            $sql,
            $params
        );
    }

    function getPasswordBy($usernameOrEmail){
        return $this->getOneValue(
            "SELECT password FROM user WHERE email  = :uore OR username = :uore",
            [
                ":uore" => $usernameOrEmail
            ]
        );
    }

    public function insertUser($username, $mail, $pass, $avatar){
        return $this->executeQuery(
            "INSERT INTO user (username, email, password, avatar) VALUES (:username, :mail, :pass, :avatar)",
            [
                ":username" => $username,
                ":mail"     => $mail,
                ":pass"     => $pass,
                ":avatar"   => $avatar
            ]
        );
    }

}
