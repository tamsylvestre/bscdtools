<?php

require_once('src/model/role.php');
require_once("src/repository/Repository.php");

class User
{
    public $cn;
    public $username;
    public $createdAt;
    public $updatedAt;

    public $roles = [];

    public function setRoles()
    {
        $this->roles = Role::UserRoles($this->cn);
    }

    public static function Users(){
        $repo = new Repository();
        $request = "SELECT * FROM user";

        $users = $repo->getAll($request);
        $tab = [];
        foreach ($users as $user) {
            $u = new User();
            $u->cn = $user['cn'];
            $u->createdAt = $user['createdAt'];
            $u->updatedAt = $user['updatedAt'];
            $u->setRoles();
            $tab[] = $u;
        }
        
        return $tab;
    }

    public function create() {
        $repo = new Repository();
        $request = "INSERT IGNORE INTO user(cn,createdAt,updatedAt) 
                    VALUES(:cn,NOW(),NOW()) 
                    ";
        $params = [
            "cn" => $this->cn
        ];

        $repo->insert($request,$params);
    }

    public function delete() {
        $repo = new Repository();
        $request = "DELETE FROM user WHERE cn = :cn";
        $params = [
            "cn" => $this->cn
        ];

        $repo->delete($request,$params);
    }

}