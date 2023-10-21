<?php
require_once PROJECT_ROOT_PATH."/Model/Database.php";

class UserModel extends Database{
    /**
     * @throws Exception if the operation fails
     */
    public function addUser($firstName, $lastName, $email, $phoneNumber, $password){
        return $this->insert("INSERT INTO users (first_name,last_name,email_address,phone_number,password) VALUES (?,?,?,?,?)",[$firstName,$lastName,$email,$phoneNumber,$password]);
    }

    /**
     * @throws Exception if the operation fails
     */
    public function getUsers($limit){
        return $this->select("SELECT * FROM users ORDER BY user_id ASC LIMIT ?",["i",$limit]);
    }
}