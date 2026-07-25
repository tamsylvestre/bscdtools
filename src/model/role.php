<?php

    require_once("src/repository/Repository.php");

    class Role
    {
        public $role_id;
        public $description;

        public function __construct()
        {
        }

        public static function Roles(){
            $repo = new Repository();
            $request = "SELECT * FROM role";

            $roles = $repo->getAll($request);
            return $roles;
        }

        public static function UserRoles($cn){
            $repo = new Repository();
            $request = "SELECT * FROM user_role WHERE cn = :cn";
            $params = ["cn"=>$cn];

            $roles = $repo->getAllWithParams($request,$params);
            return $roles;
        }
        
        
    }