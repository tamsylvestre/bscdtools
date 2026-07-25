<?php

    require_once('src/model/user.php');
    require_once('src/model/role.php');
    require_once('src/model/user_role.php');

    class C_Administration
    {

        public function __construct()
        {
            CheckUserConnect();
            var_dump($_SESSION);
        }

        function users()
        {
            $asc = [];
            $roles = Role::Roles();
            $users = User::Users();

            // var_dump($users);

            require("template/administration/user.php");
        }

        function userdetail($cn)
        {
            $c = str_replace("_",".",$cn);
            $roles = Role::UserRoles($c);

            require("template/administration/user_detail.php");
        }

        function update()
        {
            
            // var_dump($_POST);
            $u = new User();
            $u->cn = $_POST['cn'];
            $u->create();

            $roles = $_POST['roles'];
            foreach ($roles as $role) {
                $user_role = new UserRole();
                $user_role->cn = $u->cn;
                $user_role->role = $role;
                $user_role->create();
            }

            header('Location: '.BASE_URL.'/administration/users');
            exit();
        }

        function deleteuser($cn)
        {
            
            $c = str_replace("_",".",$cn);
            // var_dump($_POST);
            $u = new User();
            $u->cn = $c;
            $u->delete();


            header('Location: '.BASE_URL.'/administration/users/');
            exit();
        }

        function deleterole($cn,$role)
        {
            
            $c = str_replace("_",".",$cn);
            // var_dump($_POST);
            $u = new UserRole();
            $u->cn = $c;
            $u->role = $role;
            $u->delete();


            header('Location: '.BASE_URL.'/administration/userdetail/'.$cn);
            exit();
        }

    }