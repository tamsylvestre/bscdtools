<?php

    require_once('src/lib/database.php');
    require_once("src/model/unite.php");

    class UniteRepository
    {
        private $dbconnect;

        public function __construct($dbconnect)
        {
            $this->dbconnect = $dbconnect;
        }

        public function getAll():array
        {
            $statement = $this->dbconnect->getConection()->prepare(
                "SELECT * FROM unite_indicateur"
            );


            $statement->execute();
            
            $unites = [];

            while($row = $statement->fetch(PDO::FETCH_ASSOC))
            {        
                $unite = new Unite();
                $unite->idunite =$row['idunite'];
                $unite->description =$row['description'];

                $unites[]= $unite;
            }
            
            return $unites;

        }
        
    }