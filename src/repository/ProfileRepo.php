<?php

    require_once('src/lib/database.php');
    require_once("src/model/profile.php");

    class ProfileRepository
    {
        private $dbconnect;

        public function __construct($dbconnect)
        {
            $this->dbconnect = $dbconnect;
        }

        public function getAll():array
        {
            $statement = $this->dbconnect->getConection()->prepare(
                "SELECT * FROM profile"
            );


            $statement->execute();
            
            $profiles = [];

            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {        
                $profile = new Profile();
                $profile->user =$row['user'];
                $profile->kpi_responsible =$row['kpi_responsible'];

                $profiles[]= $profile;
            }
            
            return $profiles;

        }

        public function getUserProfile($userid)
        {
            $statement = $this->dbconnect->getConection()->prepare(
                "SELECT * FROM profile WHERE user = :userid"
            );

            $statement->bindParam(':userid', $userid);

            $statement->execute();
            
            if($row = $statement->fetch(PDO::FETCH_ASSOC))
            {        
                // $profile = new Profile();
                // $profile->user =$row['user'];
                // $profile->kpi_responsible =$row['kpi_resposible'];

                return  $row;
            }
            
            return [];

        }
        
    }