<?php

    require_once('src/lib/database.php');
    require_once("src/model/user.php");

    class UserRepository
    {
        private $dbconnect;

        public function __construct($dbconnect)
        {
            $this->dbconnect = $dbconnect;
        }

        public function getAll():array
        {
            $statement = $this->dbconnect->getConection()->prepare(
                "SELECT * FROM user WHERE admin is NULL"
            );


            $statement->execute();
            
            $users = [];

            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {        
                $user = new User();
                $user->userid =$row['userid'];
                $user->username =$row['username'];
                $user->useremail =$row['useremail'];
                $user->admin =$row['admin'];

                $users[]= $user;
            }
            
            return $users;

        }

        public function getById($userid)
        {
            $statement = $this->dbconnect->getConection()->prepare(
                "SELECT * FROM user WHERE userid = :userid"
            );

            $statement->bindParam(':userid', $userid);

            $statement->execute();
            

            if($row = $statement->fetch(PDO::FETCH_ASSOC))
            {        
                return  $row;
            }
            
            return [];

        }
        
    }