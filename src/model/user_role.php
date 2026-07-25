<?php

    require_once("src/repository/Repository.php");

    class UserRole
    {
        public $role;
        public $cn;

        public function __construct()
        {
        }

        public function create() {
            $repo = new Repository();
            $request = "INSERT IGNORE INTO user_role(cn,role) 
                        VALUES(:cn,:role) 
                        ";
            $params = [
                "cn" => $this->cn,
                "role" => $this->role
            ];
            // print $this->cn;
            $repo->insert($request,$params);
        }

        public function delete() {
            $repo = new Repository();
            $request = "DELETE FROM user_role WHERE cn = :cn AND role = :role";
            $params = [
                "cn" => $this->cn,
                "role" => $this->role
            ];

            $repo->delete($request,$params);
        }
        
        public static function UserRoles($cn){
            $repo = new Repository();
            $request = "SELECT * FROM user_role WHERE cn = :cn";
            $params = ["cn"=>$cn];

            $roles = $repo->getAllWithParams($request,$params);
            return $roles;
        }
        
    }