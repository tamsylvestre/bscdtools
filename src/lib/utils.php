<?php

    function CheckUserConnect()
    {
        if(!isset($_SESSION['user']))
        {
            $error = "Vous devez vous connecter !!!";
            require("template/connexion.php");
            die();
        }
    }

    function ShowIfAuth($roles,$role)
    {
        if(!in_array($role, array_column($roles, 'role')))
        {
            print 'invisible';
        }
    }

    function CheckIfAuth($roles,$role)
    {
        if(!in_array($role, array_column($roles, 'role')))
        {
            $error = "Vous ne pouvez acceder à cette page !!!";
            require("template/connexion.php");
            die();
        }
    }